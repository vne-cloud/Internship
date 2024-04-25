<?
require_once($_SERVER['DOCUMENT_ROOT'].'/admin/config.php');
echo $HEADER;
if(ADMIN <> "true" && MODER <> "true")
{
	header("location: /admin");
	exit;
}

$table = 'catalog';

$page_res = mysql_query("SELECT * FROM `page` WHERE `id` = '2'");
$page_row = mysql_fetch_array($page_res);

if(isset($_GET['edit']) || isset($_GET['add']))
{
	$id = dataprocessing($_GET['id']);
	$result=mysql_query("SELECT * FROM `{$table}` WHERE id='".$id."' LIMIT 1");
	if(mysql_num_rows($result)<>0 || isset($_GET['add']))
	{
		$row = mysql_fetch_array($result);

		if($row['show'] == 1) $ch = "checked='checked'";
		if (isset($_GET['add'])) $ch = "checked='checked'";

		if (isset($_GET['add'])) $site_link = SITE;
		else {
			$cat_res = mysql_query("SELECT * FROM `catalog_cat` WHERE id = '{$row['catalog_cat']}'");
			$cat_row = mysql_fetch_array($cat_res);
			$site_url = "/{$page_row['url']}/{$cat_row['url']}/{$row['url']}";
			$site_link = "<a href='".$site_url."' target='_blank' class='contentShow'>Смотреть на сайте</a>";
		}

		echo "<h1>".heads($row['name'])."</h1>
		".BACK."
		".$site_link."
		<form action='".$_SERVER['PHP_SELF']."' method='post'  enctype='multipart/form-data'>
			".show($ch)."
			".select('catalog_cat', $row['catalog_cat'], 'Категория', '', "", 'catalog_cat')."
			".input('name', $row['name'], 'Название:', 'required')."
			".input('url', $row['url'], 'Ссылка:', '', '', '(автоматически, если пусто)')."
			<fieldset>
				<legend>Превью</legend>
				".image('', 'Картинка на превью', 'размеры 380x400px', $row, $table)."
			</fieldset>
			<fieldset>
				<legend>Детальная страница</legend>
				".image(2, 'Картинка детальная', 'макс. ширина 1210px', $row, $table)."
				".textbox('text', $row['text'], 'Текст:', '400')."
			</fieldset>
			".plus('Заголовок', 'catalog', $id)."
			<fieldset>
				<legend>Фотогалерея</legend>
				".gallbox('catalog', $id, 'Размеры фото: 1000x639px')."
			</fieldset>
			".input('rate', $row['rate'], 'Рейтинг:')."
			<div class='formbox_submit'>";
				if (isset($_GET['add']))
					echo "<input name='add' type='submit' value='".SEND."' class='button' />";
				else {
					echo "<input name='id' type='hidden' value='".$id."' />
					<input name='edit' type='submit' value='".SEND."' class='button' />";
				}
			echo "</div>
		</form>";
	}
}
else if(isset($_POST['edit']) || isset($_POST['add']))
{
	if (isset($_POST['add'])) $_SESSION['notice'] = 'Добавлено';
	else $_SESSION['notice'] = "Изменено";

	$id = dataprocessing($_POST['id']);
	$show = dataprocessing($_POST['show']);
	$name = adataprocessing($_POST['name']);
	$url = adataprocessing($_POST['url']);
	if (empty($url)) $url = rus_to_eng($name);
	$rate = dataprocessing($_POST['rate']);
	$text = adataprocessing($_POST['text']);
	$catalog_cat = adataprocessing($_POST['catalog_cat']);

	$img1 = image_upload('', $table, 380, 400, 1, $id);
	$img2 = image_upload(2, $table, 1210, 1210, 2, $id);

	$str = "`show` = '{$show}'
	  , `name` = '".$name."'
		, `url` = '".$url."'
		, `rate` = '".$rate."'
		, `text` = '".$text."'
		, `catalog_cat` = '".$catalog_cat."'
		{$img1}
		{$img2}
	";

	if (isset($_POST['add'])) {
		mysql_query("INSERT INTO `{$table}` SET
			".$str."
		");
		$id = mysql_insert_id();
	}
 	else {
		mysql_query("UPDATE `{$table}` SET
			".$str."
			WHERE id='".$id."'
		");
	}

	urls($table, $id, $url, $name); //одинаковые ссылки

	gallsave(1000, 639, 'catalog', $id);

	header("location: ".$_SERVER['PHP_SELF']."?edit&id=".$id."");
	exit;
}
else if(isset($_GET['delete']))
{
	$_SESSION['notice'] = "Удалено";
	$id = dataprocessing($_GET['id']);

	image_del($id, $table, 'path');
	image_del($id, $table, 'path2');

	mysql_query("DELETE FROM `{$table}` WHERE id='".$id."'");

	header("location: ".$_SERVER['PHP_SELF']."");
	exit;
}
else
{
	echo "<h1>".h1()."</h1>";
	$table = table();

	$search = $where = "";
	if(!empty($_GET['search'])) {
		$search = adataprocessing($_GET['search']);
		$where .= " AND (`name` LIKE '%".$search."%')";
	}
	$catalog_cat = adataprocessing($_GET['catalog_cat']);
	if(!empty($catalog_cat)) {
		$where .= " AND catalog_cat = '".$catalog_cat."'";
	}

	echo "<div class='filter'>
		<div class='filterHead'>Фильтр</div>
		<form name='' action='".$_SERVER['PHP_SELF']."' method='GET'>
			<div class='formbox-left'>
				".search($search)."
			</div>
			<div class='formbox-right'>
				".select_filt('catalog_cat', $catalog_cat, 'Категория:', "", 'catalog_cat')."
			</div>
			<div class='clear'></div>
		</form>
	</div>
	<a href='".$_SERVER['PHP_SELF']."?add' class='add'><span>Добавить</span></a>";

	$query = "SELECT * FROM `{$table}` WHERE 1=1 ".$where." ORDER BY rate DESC, id DESC";

	$sq = mysql_query($query);
	$all = mysql_num_rows($sq);
	if ($all) {

		echo "<div class='list-count'>Найдено записей: ".$all."</div>";
		echo "<div class='listContent'>";

			$pnumber = 100;
			$page = dataprocessing($_GET['page']);
			$nav = $pnumber * $page;
			$n = new Navigator($all, $pnumber, get());

			echo "<table class='table'>
				<thead>
					<tr>
						<th>Название</th>
						<th>Категория</th>
						<th style='min-width: 80px;'>Картинка</th>
						<th class='sorter-false'></th>
					</tr>
				</thead>
				<tbody>";

				$q = mysql_query($query." LIMIT ".$n->start().",$pnumber");
				while ($row = mysql_fetch_array($q)) {

					$img = image_view($table, $row['path']);

					$catalog_cat = '';
					if (!empty($row['catalog_cat'])) {
						$cat_res  = mysql_query("SELECT * FROM `catalog_cat` WHERE `id` = '".$row['catalog_cat']."'");
						$cat_row = mysql_fetch_array($cat_res);
						$catalog_cat = $cat_row['name'];
					}

					echo "<tr>
						<td class='tr-bold'>".$row['name']."</td>
						<td>".$catalog_cat."</td>
						<td>{$img}</td>
						<td class='edits'>".edits($table, $row)."</td>
					</tr>";
				}

			echo "</tbody>
			</table>";

			echo $n->navi();

		echo "</div>";
	}
	else {
		echo "<div class='formbox_show'>Ничего не найдено</div>";
	}
}

echo $FOOTER;
?>
