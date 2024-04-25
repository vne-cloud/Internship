<?php
require_once('config.php');


/* --- Показывать на сайте --- */

if(isset($_POST['admin_show']))
{
	$id = dataprocessing($_POST['id']);
	$table = dataprocessing($_POST['table']);
	$show = dataprocessing($_POST['show']);

	mysql_query("UPDATE `".$table."` SET `show`=".$show." WHERE id = '".$id."'");
}

/* --- // --- */


/* --- Поиск --- */

else if(isset($_POST['search_news']))
{
	$_SESSION['search_news'] = dataprocessing($_POST['search_news']);
	header("location: ".$_SERVER['HTTP_REFERER']."");
	exit;
}

/* --- // --- */


/* --- Поиск --- */

else if(isset($_POST['search_page']))
{
	$_SESSION['search_page'] = dataprocessing($_POST['search_page']);
	header("location: ".$_SERVER['HTTP_REFERER']."");
	exit;
}

/* --- // --- */


/* --- Фильтр --- */

else if(isset($_POST['news_type']))
{
	$_SESSION['news_type'] = dataprocessing($_POST['news_type']);
	header("location: ".$_SERVER['HTTP_REFERER']."");
	exit;
}

/* --- // --- */



/* --- Рейтинг --- */

else if(isset($_POST['admin_rate']))
{
	$id = dataprocessing($_POST['id']);
	$table = dataprocessing($_POST['table']);
	$rate = dataprocessing($_POST['rate']);

	mysql_query("UPDATE `".$table."` SET `rate`=".$rate." WHERE id = '".$id."'");
}

/* --- // --- */



/* --- Статус заявок --- */

else if(isset($_POST['status_sends']))
{
	$id = dataprocessing($_POST['id']);
	$status = dataprocessing($_POST['status']);
	mysql_query("UPDATE sends SET status = '".$status."' WHERE id = '".$id."'");
}

/* --- // --- */


/* --- Заявки фильтр --- */

else if(isset($_POST['admin_search_status']))
{
	$_SESSION['admin_search_status'] = dataprocessing($_POST['admin_search_status']);
	header("location: ".$_SERVER['HTTP_REFERER']."");
	exit;
}

/* --- // --- */


/* --- Если из структуры --- */

else if(isset($_POST['admin_structure']))
{
	$val = dataprocessing($_POST['val']);
	$_SESSION['admin_structure'] = $val;
}

/* --- // --- */


/* --- Если из структуры раздел --- */

else if(isset($_POST['admin_structure_part']))
{
	$part = dataprocessing($_POST['part']);
	$val = dataprocessing($_POST['val']);
	if ($val == 1) $_SESSION['admin_structure_'.$part] = 1;
	else $_SESSION['admin_structure_'.$part] = 0;
}

/* --- // --- */


/* --- Удаление из структуры --- */

else if(isset($_POST['admin_del']))
{
	$table = dataprocessing($_POST['table']);
	$id = dataprocessing($_POST['id']);

	mysql_query("DELETE FROM `".$table."` WHERE id = '".$id."' LIMIT 1");
}

/* --- // --- */


/* --- Перетаскивание --- */

else if(isset($_POST['sort_filter']))
{
	$table = dataprocessing($_POST['table']);
	$nav = dataprocessing($_POST['nav']);
	$filter = $_POST['filter'];
	$i = 1000000 - $nav;
	foreach($filter AS $item) {
		mysql_query("UPDATE `".$table."` SET rate = '".$i."' WHERE id = '".$item."'");
		$i = $i - 1;
	}
}

/* --- // --- */


/* --- Статус заявок --- */

else if(isset($_POST['sends_status']))
{
	$id = dataprocessing($_POST['sends_status']);
	$status = dataprocessing($_POST['status']);
	mysql_query("UPDATE sends SET arhiv = '{$status}' WHERE id = '{$id}'");
}

/* --- // --- */


/* --- Статус заявок --- */

else if(isset($_POST['radio_type']))
{
	$type = adataprocessing($_POST['radio_type']);
	$cat = adataprocessing($_POST['cat']);
	echo select('catalog_cat', $cat, 'Категория:', 'required', " AND `type` = '{$type}'", '', ' type ASC,');
}

/* --- // --- */


/* --- Items add --- */

else if(isset($_POST['items_add'])) {
	$type = adataprocessing($_POST['type']);
	$ids = adataprocessing($_POST['ids']);

	mysql_query("INSERT INTO `items` SET
		`type` = '{$type}'
		, `ids` = '{$ids}'
	");

	echo items($type, $ids);
}

/* --- // --- */


/* --- Items change --- */

else if(isset($_POST['items_change'])) {
	$id = adataprocessing($_POST['id']);
	$name = adataprocessing($_POST['name']);
	$field = adataprocessing($_POST['field']);

	mysql_query("UPDATE `items` SET `{$field}` = '{$name}' WHERE `id` = '{$id}'");
}

/* --- // --- */


/* --- Items get_declared_classes --- */

else if(isset($_POST['items_del'])) {
	$id = adataprocessing($_POST['id']);

	mysql_query("DELETE FROM `items` WHERE `id` = '{$id}'");
}

/* --- // --- */

?>
