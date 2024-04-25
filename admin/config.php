<?php

/* --- Сброс кэша файлов --- */

if (function_exists('opcache_reset')) {
  opcache_reset();
}

/* --- // --- */


/* --- Ошибки --- */

ini_set('error_reporting', 0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/* --- // --- */


/* --- Соединение с базой MYSQL --- */

require_once('db.php');
require_once('admin_functions.php');

/* --- // --- */


/* --- Определение пользователя --- */

if(isset($_COOKIE['user']))
{
	$user = dataprocessing($_COOKIE['user']);
}
elseif(isset($_SESSION['user']))
{
	$user = dataprocessing($_SESSION['user']);
}

$user = explode("|",$user);
$username = $user['0'];
$userpassword = $user['1'];
$usersearch = mysql_query("SELECT * FROM user WHERE login='".$username."' AND password='".$userpassword."' LIMIT 1");
if (mysql_num_rows($usersearch) <>0) {
	$usersearchresult = mysql_fetch_array($usersearch);
	mysql_query("UPDATE user SET lastvisit='".time()."' WHERE login='".$username."' AND password='".$userpassword."'");
	define("USER_LASTVISIT", time());
	define("USER", "true");
	define("USER_LOGIN", $usersearchresult['login']);
	define("USER_ID", $usersearchresult['id']);
	$USER_TYPE = '';

	switch($usersearchresult['class']) {
		case 1:
			define("ADMIN", "true");
			$USER_TYPE = 'Администратор';
			break;
		case 2:
			define("MODER", "true");
			$USER_TYPE = 'Модератор';
			break;
	}

	if ($USER_TYPE <> "") $USER_TYPE = "(".$USER_TYPE.")";
	define("USER_TYPE", $USER_TYPE);

	define("MENU", $usersearchresult['menu']);
	define("VIEW", $usersearchresult['view']);
	define("FONT", $usersearchresult['font']);
	define("LIGHT", $usersearchresult['light']);
}
else
{
	if (isset($_COOKIE['user']))
	{
		setcookie("user", "", time() - 7200, "/", $_SERVER['SERVER_NAME'], "1");
	}
	session_destroy();
	define("USER_LASTVISIT", time());
	define("USER", "");
	define("USER_LOGIN", "");
	define("USER_ID", "");
	define("ADMIN", false);
	define("MODER", false);
}

/* --- // --- */


/* --- СПРАВОЧНИКИ --- */

$references = array();

//$references['links'][] = 'country.php';
//$references['names'][] = 'Страны';

/* --- // --- */


/* --- МОДУЛИ --- */

$modules = array();

$modules['links'][] = 'catalog_cat.php';
$modules['names'][] = 'Каталог. Категории';

$modules['links'][] = 'catalog.php';
$modules['names'][] = 'Каталог';

/* --- // --- */


/* --- Баннеры --- */

$banners = array();

$banners['links'][] = 'banners.php';
$banners['names'][] = 'Баннеры верхние';

/* --- // --- */


/* --- Заявки --- */

$sends = array();

$sends['links'][] = 'send.php';
$sends['names'][] = 'Заявки';

/* --- // --- */


/* --- ОСНОВНЫЕ РАЗДЕЛЫ --- */

$parts = array();
if (ADMIN == "true" || MODER == "true") $parts[] = "desktop|desktop.php|Рабочий стол|1";
if (ADMIN == "true" || MODER == "true") $parts[] = "references|references.php|Справочники|3";
if (ADMIN == "true" || MODER == "true") $parts[] = "modules|modules.php|Модули|4";
if (ADMIN == "true" || MODER == "true") $parts[] = "pages|page.php|Страницы|10";
if (ADMIN == "true" || MODER == "true") $parts[] = "banners|banners.php|Баннеры|5";
if (ADMIN == "true") $parts[] = "users|users.php|Пользователи|6";
if (ADMIN == "true") $parts[] = "sends|send.php|Заявки|7";
if (ADMIN == "true" || MODER == "true") $parts[] = "seo|seo.php|SEO|8";
if (ADMIN == "true" || MODER == "true") $parts[] = "setting|setting.php|Настройки|9";

/* --- // --- */


$cres = mysql_query("SELECT * FROM setting WHERE id='1' LIMIT 1");
$crow = mysql_fetch_array($cres);



/* --- Константы --- */

define ("EDIT", "Редактировать");
define ("DELETE", "Удалить");
define ("SEND", "Сохранить");
define ("SITE", "<a href='/' target='_blank' class='contentShow'>Перейти на сайт</a>");
define ("BACK", "<a href='".$_SERVER['PHP_SELF']."' class='contentShow contentBack'>Назад к списку</a>");

/* --- // --- */

$param=$_SERVER['REQUEST_URI'];
$params=explode("/",$param);
$params=Clear_array($params);



/* --- Кнопки показа всех записей и добавления новой --- */

if($_SERVER['PHP_SELF'] <> "/admin/setting.php")
{
	$button = "<a href='".$_SERVER['PHP_SELF']."' class='top_button'>Показать</a>
	<a href='".$_SERVER['PHP_SELF']."?add' class='top_button'>Добавить</a>";
}
else $button = "";

/* --- // --- */



/* --- Тема --- */

define ("THEME_NAME", "VT");
ini_set('include_path', getenv("DOCUMENT_ROOT")."/");
define ("THEME", 'theme/'.THEME_NAME);
define("THEME_FOLDER", "/admin/theme/".THEME_NAME."/");
define ("CSS", "/admin/theme/".THEME_NAME."/style.css?".rand());
define ("JQUERY", "/admin/js/jquery.js?v=5");
define ("FCKEDITOR", "/admin/ckeditor/ckeditor.js");
require_once(THEME."/theme.php");

/* --- // --- */


?>
