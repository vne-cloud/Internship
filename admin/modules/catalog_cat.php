<?
require_once($_SERVER['DOCUMENT_ROOT'].'/admin/config.php');
echo $HEADER;
if(ADMIN <> "true" && MODER <> "true")
{
	header("location: /admin");
	exit;
}

$table = 'catalog_cat';

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
		else $site_link = "<a href='/".$page_row['url']."/".$row['url']."' target='_blank' class='contentShow'>Посмотреть на сайте</a>";

		echo "<h1>".heads($row['name'])."</h1>
		".BACK."
		".$site_link."
		<form action='".$_SERVER['PHP_SELF']."' method='post'  enctype='multipart/form-data'>
			".show($ch)."
			".input('name', $row['name'], 'Название:', 'required')."
			".input('url', $row['url'], 'Ссылка:', '', '', '(автоматически, если пусто)')."
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

	$str = "`show` = '{$show}'
	  , `name` = '".$name."'
		, `url` = '".$url."'
		, `rate` = '".$rate."'
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

	header("location: ".$_SERVER['PHP_SELF']."?edit&id=".$id."");
	exit;
}
else if(isset($_GET['delete']))
{
	$_SESSION['notice'] = "Удалено";
	$id = dataprocessing($_GET['id']);

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

	echo "<div class='filter'>
		<div class='filterHead'>Фильтр</div>
		<form name='' action='".$_SERVER['PHP_SELF']."' method='GET'>
			<div class='formbox-left'>
				".search($search)."
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
						<th class='sorter-false'></th>
					</tr>
				</thead>
				<tbody>";

				$q = mysql_query($query." LIMIT ".$n->start().",$pnumber");
				while ($row = mysql_fetch_array($q)) {

					echo "<tr>
						<td class='tr-bold'>".$row['name']."</td>
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
