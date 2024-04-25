<?

/* --- Окно предупреждения --- */

if(@$_SESSION['notice'] <> "") {
	$notice = "<div class='notice'>
		<div id='black' style='display: block; opacity: 0.4;'></div>
		<div id='alert' class='anime14'>
			<div id='alert_head'>Предупреждение</div>
			<br />
			".$_SESSION['notice']."<br /><br />
			<input type='button' value='OK' class='button_alert' />
		</div>
	</div>";
}
else $notice = "";

/* --- // --- */


/* --- Переменная показа сайта до центрального текста --- */

$HEADER = "<!DOCTYPE html>
<html class='".(LIGHT == 1 ? "bodyLight" : "")."'>
<head>
	<meta charset='UTF-8' />
	<title>Панель управления сайтом | VisualTeam</title>
	<link rel='stylesheet' type='text/css' href='".THEME_FOLDER."css/chosen.css?".rand()."' />
	<link rel='stylesheet' type='text/css' href='".CSS."?v=1' />
	<link rel='shortcut icon' href='/admin/favicon.ico' />
	<script src='".JQUERY."'></script>
	<script src='".FCKEDITOR."'></script>
</head>
<body class='admin ".(VIEW == 1 ? "bodyView" : "")." ".(LIGHT == 1 ? "bodyLight" : "")." ".(MENU == 1 ? "menuCompact menuCompactUser" : "")."'>
	<script src='/admin/js/admin.js?".rand()."'></script>
	<div id='black'></div>
	<div id='mod'>
		<div class='close'></div>
		<div id='modbox'></div>
	</div>
	<header class='admin_header'>
		<a href='/' target='_blank' class='logo'></a>
		<section class='head_user'>
			<!--<a href='/admin/readme.php' target='_blank' class='head_inst'>Инструкция</a>-->
			<span class='head_user_txt'>Вы вошли как:</span>
			<span class='head_user_name'>".USER_LOGIN." <span class='head_user_type'>".USER_TYPE."</span></span>
			<a href='/admin/index.php?destroy' class='head_user_out'>Выйти</a>
		</section>
		<div class='clear'></div>
	</header>
	<div class='vtable all'>
		<div class='vrow'>
			<nav class='left vcell'>
				".admin_menu()."
				<div class='copy'>
					&copy; 2011 - ".date('Y',time())." VisualTeam Ltd. Co.
				</div>
			</nav>
			".left_pages()."
				".content()."
";

/* --- // --- */


/* --- Переменная показа сайта после центрального текста --- */

$FOOTER = "			</div>
				</div>
			</section>
		</div>
	<div class='clear'></div>
	".$notice."
	<script src='/admin/js/table-sorter.js?v=2'></script>
	<script src='/admin/js/chosen.js?v=2'></script>
	<script src='/admin/js/main.js?".rand()."'></script>
</body>
</html>";

/* --- // --- */


/* --- Переменная показа сайта до центрального текста (авторизация) --- */

$IHEADER = "<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8' />
	<title>Панель управления сайтом | VisualTeam</title>
	<link rel='stylesheet' type='text/css' href='".CSS."?v=1' />
	<link rel='shortcut icon' href='/admin/favicon.ico' />
	<script src='".JQUERY."'></script>
	<script src='".FCKEDITOR."'></script>
</head>
<body class='index'>
	<div class='indexTable'>
		<div class='indexRow'>
			<div class='indexCell'></div>
			<div class='indexCell indexCell2'></div>
		</div>
	</div>
	<div class='index_content'>
		<section class='logo_index'><img src='".THEME_FOLDER."images/logo.png' alt='' /></section>
";

/* --- // --- */


/* --- Переменная показа сайта после центрального текста (авторизация) --- */

$IFOOTER = "
	</div>
	<script src='/admin/js/table-sorter.js?v=2'></script>
	<script src='/admin/js/chosen.js?v=2'></script>
	<script src='/admin/js/main.js?".rand()."'></script>
</body>
</html>";

/* --- // --- */

unset($_SESSION['notice']);

?>
