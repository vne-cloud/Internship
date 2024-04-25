<?
require_once('../config.php');

echo $HEADER;
if(ADMIN <> "true" && MODER <> "true")
{
	header("location: /admin");
	exit;
}

if(isset($_GET['edit']) || isset($_GET['add']))
{
	$id = dataprocessing($_GET['id']);
	$result=mysql_query("SELECT * FROM `page` WHERE id='".$id."' LIMIT 1");
	if(mysql_num_rows($result)<>0 || isset($_GET['add']))
	{
		$row = mysql_fetch_array($result);

		if($row['show'] == 1) $ch = "checked='checked'";
		else $ch = "";
		if (isset($_GET['add'])) $ch = "checked='checked'";

		$site_url = "/".$row['url'];
		$site_link = "<a href='".$site_url."' target='_blank' class='contentShow'>Посмотреть на сайте</a>";

		echo "<h1>".heads($row['name'], 'страницы')."</h1>
		".BACK."
		".$site_link."
		<form action='".$_SERVER['PHP_SELF']."' method='post'  enctype='multipart/form-data'>
			<div class='tabs tabs1'>
				<div class='column'>
					".show($ch)."
					".cbx('В верхнем меню:', 'menu', $row, 'Показывать')."
					".cbx('В подвале:', 'foot_menu', $row, 'Показывать')."
				</div>
				".input('name', $row['name'], 'Название:', 'required')."
				".input('name2', $row['name2'], 'Название длинное:')."
				".input('url', $row['url'], 'Ссылка (автоматом):')."
				".textbox('text', $row['text'], 'Текст:', 400)."
				".input('rate', $row['rate'], 'Рейтинг:')."
			</div>
			<div class='tabs tabs2' style='display: none;'>
				".input('title', $row['title'], 'Title:')."
				".input('keywords', $row['keywords'], 'Keywords:')."
				".input('description', $row['description'], 'Description:')."
			</div>
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
	else $_SESSION['notice'] = "Успешно сохранено";
	$id = dataprocessing($_POST['id']);
	$show = dataprocessing($_POST['show']);
	$menu = dataprocessing($_POST['menu']);
	$top = dataprocessing($_POST['top']);
	$foot_menu = dataprocessing($_POST['foot_menu']);
	$foot_menu2 = dataprocessing($_POST['foot_menu2']);
	$name = adataprocessing($_POST['name']);
	$name2 = adataprocessing($_POST['name2']);
	$rate = dataprocessing($_POST['rate']);
	$opis = adataprocessing($_POST['opis']);
	$opis2 = adataprocessing($_POST['opis2']);
	$text = adataprocessing($_POST['text']);
	$url = dataprocessing($_POST['url']);
	if (empty($url))
		$url = rus_to_eng($name);

	$title = dataprocessing($_POST['title']);
	$keywords = dataprocessing($_POST['keywords']);
	$description = dataprocessing($_POST['description']);

	$count = time();
	chdir("../../public/images/page/");

	$str = "`show` = '".$show."'
		, `menu` = '".$menu."'
		, `top` = '".$top."'
		, `foot_menu` = '".$foot_menu."'
		, `foot_menu2` = '".$foot_menu2."'
		, `name` = '".$name."'
		, `name2` = '".$name2."'
		, `rate` = '".$rate."'
		, `opis` = '".$opis."'
		, `text` = '".$text."'
		, `url` = '".$url."'
		, `title` = '".$title."'
		, `keywords` = '".$keywords."'
		, `description` = '".$description."'
		";

	if (isset($_POST['add'])) {
		mysql_query("INSERT INTO page SET
			".$str."
		");
		$id = mysql_insert_id();
	}
 	else {
		mysql_query("UPDATE page SET
			".$str."
			WHERE id='".$id."'
		");
	}

	//одинаковые ссылки
	urls('page', $id, $url, $name);

	header("location: ".$_SERVER['PHP_SELF']."?edit&id=".$id."");
	exit;
}
else if(isset($_GET[delete]))
{
	$_SESSION['notice'] = "Удалено";
	$id = dataprocessing($_GET['id']);

	if ($id <> 12) {
		mysql_query("DELETE FROM page WHERE id='".$id."'");
	}

	header("location: ".$_SERVER['PHP_SELF']."");
	exit;
}
else
{
	echo "<h1>Страницы</h1>";
	$table = 'page';

	$search = $where = "";
	if(!empty($_SESSION['search_page'])) {
		$search = $_SESSION['search_page'];
		$where = " AND name LIKE '%".$search."%' ";
	}

	echo "<div class='filter'>
		<div class='filterHead'>Фильтр</div>
		<form action='/admin/admin_ajax.php' method='POST'>
			<div class='formbox'>
				<div class='label'>Название:</div>
				<input type='text' name='search_page' value='".$search."' class='input input3' maxlength='255' placeholder='Введите название' />
				<input type='submit' name='submit' id='ss' class='button' value='Поиск' style='float: right; margin: 0px 0px 0px 10px; cursor: pointer;' />
			</div>
		</form>
	</div>
	<a href='".$_SERVER['PHP_SELF']."?add' class='add'><span>Добавить страницу</span></a>";

	echo "<div class='listContent'>";

		$sq=mysql_query("SELECT * FROM page WHERE 1=1 ".$where."");
		$all=mysql_num_rows($sq);
		if ($all)
		{
			$pnumber=50;
			$n = new Navigator($all, $pnumber, "");
			$q=mysql_query("SELECT * FROM page WHERE 1=1 ".$where." ORDER BY id DESC LIMIT ".$n->start().",$pnumber");
			echo $n->navi();
			while ($row=mysql_fetch_array($q))
			{
				$id = $row['id'];

				$foot = "";
				if ($row['foot_menu'] == 1 || $row['foot_menu2'] == 1) $foot = "<div class='listSmall listSmall2'>Показывается в нижнем меню</div>";

				$menu = "";
				if ($row['menu'] == 1) $menu = "<div class='listSmall listSmall2'>Показывается в верхнем меню</div>";

				$top = "";
				if ($row['top'] == 1) $top = "<div class='listSmall listSmall2'>Показывается в выпадающем меню</div>";

				$page = "";
				if (!empty($row['page'])) {
					$rres = mysql_query("SELECT * FROM page WHERE id = '".$row['page']."'");
					$rrow = mysql_fetch_array($rres);
					$page = "<div class='listSmall'>Родительская страница: ".$rrow['name']."</div>";
				}

				$cl = "";
				if($row['show'] == 1) $cl = "admin_show_act";

				$site_url = "/".$row['url']."";

				$del = "";
				if ($id > 13) {
					$del = "<a class='admin_del delete-all' title='Удалить' id='delete".$row['id']."' href='".$_SERVER['PHP_SELF']."?delete&amp;id=".$row['id']."'></a>";
				}
				echo "<div class='formbox_show'>
					<div class='vtable'>
						<div class='vrow'>
							<div class='vcell'>
								<div class='show_name'>
									<div>".$row['name']."</div>
									".$page."
									".$menu."
									".$top."
									".$foot."
								</div>
							</div>
							<div class='vcell'>
								<div class='admins'>
									{$del}
									<a class='admin_edit' title='Редактировать' href='".$_SERVER['PHP_SELF']."?edit&amp;id=".$row['id']."'></a>
									<a class='admin_open' title='Смотреть на сайте' target='_blank' href='".$site_url."'></a>
									<div class='admin_show ".$cl."' title='Показывать на сайте' data-id='".$row['id']."' data-table='".$table."'></div>
								</div>
								<div class='clear'></div>
							</div>
						</div>
					</div>
				</div>";
			}
		}
		else {
			echo "<div class='formbox_show'>Ничего не найдено</div>";
		}

	echo "</div>";

	if ($all) echo $n->navi();
}

echo $FOOTER;
?>
