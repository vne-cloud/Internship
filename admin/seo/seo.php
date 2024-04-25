<?php
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
	$result=mysql_query("SELECT * FROM seo WHERE id='".$id."' LIMIT 1");
	if(mysql_num_rows($result)<>0 || isset($_GET['add']))
	{
		$row=mysql_fetch_array($result);

		if(isset($_GET['url']) && isset($_GET['add'])) $url = dataprocessing($_GET['url']);
		else $url = $row['url'];

		if (isset($_GET['add'])) $head = "Добавление";
		else $head = "Редактирование";

		echo "<h1>".$head.": SEO</h1>
		".BACK."
		<a href='".$row['url']."' target='_blank' class='contentShow'>Посмотреть на сайте</a>
		<form action='".$_SERVER['PHP_SELF']."' method='post'>
			<div class='formbox'>
				<div class='label'>Url страницы:</div>
				<input type='text' name='url' value='".$url."' class='input' maxlength='500' required />
			</div>
			<div class='formbox'>
				<div class='label'>Title:</div>
				<input type='text' name='title' value='".$row['title']."' class='input' maxlength='500' />
			</div>
			<div class='formbox'>
				<div class='label'>Description:</div>
				<input type='text' name='desc' value='".$row['description']."' class='input' maxlength='500' />
			</div>
			<div class='formbox'>
				<div class='label'>Keywords:</div>
				<input type='text' name='key' value='".$row['keywords']."' class='input' maxlength='500' />
			</div>
			<div class='formbox_submit'>";
				if (isset($_GET['add']))
					echo "<input name='add' type='submit' value='".SEND."' class='button' />";
				else {
					echo "<input type='hidden' name='id' value='".$id."' />
					<input name='edit' type='submit' value='".SEND."' class='button' />";
				}
			echo "</div>
		</form>";
	}
}
else if(isset($_POST['edit']) || isset($_POST['add']))
{
	$id = dataprocessing($_POST['id']);
	if (isset($_POST['add'])) $_SESSION['notice'] = "Успешно добавлено";
	else $_SESSION['notice'] = "Успешно изменено";
	$url = dataprocessing($_POST['url']);
	$title = dataprocessing($_POST['title']);
	$key = dataprocessing($_POST['key']);
	$desc = dataprocessing($_POST['desc']);
	
	$server = $_SERVER['SERVER_NAME'];
	$url = str_replace($server, '', $url);
	$url = str_replace('http://', '', $url);
	$url = str_replace('https://', '', $url);
	$url = str_replace('//', '', $url);
	$url = str_replace('.xsph.ru', '', $url);

	$str = "
	`url`='".$url."'
	, `title`='".$title."'
	, `keywords`='".$key."'
	, `description`='".$desc."' ";

	if (isset($_POST['add'])) {
		mysql_query("INSERT INTO `seo` SET
			".$str."
		");
		$id = mysql_insert_id();
	}
	else {
		mysql_query("UPDATE `seo` SET
			".$str."
			WHERE `id`='".$id."'
		");
	}

	header("location: ".$_SERVER['PHP_SELF']."?edit&id=".$id."");
	exit;
}
else if(isset($_GET[delete]))
{
	$_SESSION['notice'] = "Удалено";
	$id = dataprocessing($_GET['id']);

	mysql_query("DELETE FROM `seo` WHERE id='".$id."'");

	header("location: ".$_SERVER['PHP_SELF']."");
	exit;
}
else
{
	echo "<h1>SEO</h1>
	<a href='/' target='_blank' class='contentShow'>Посмотреть на сайте</a>
	<a href='".$_SERVER['PHP_SELF']."?add' class='add'><span>Добавить seo</span></a>";

	$q=mysql_query(" SELECT * FROM `seo`");
	$all = mysql_num_rows($q);
	if ($all) {
		echo "<div class='listContent'>";

		$pnumber = 300;
		$n = new Navigator($all, $pnumber, "");
		$q=mysql_query("SELECT * FROM `seo` ORDER BY id DESC LIMIT ".$n->start().",$pnumber");
		echo $n->navi();
		while ($row = mysql_fetch_array($q))
		{
			echo "<div class='formbox_show'>
				<div class='vtable'>
					<div class='vrow'>
						<div class='vcell'>
							<div class='show_name'>
								<div>".$row['url']."</div>
							</div>
						</div>
						<div class='vcell'>
							<div class='admins'>
								<a class='admin_del' title='Удалить' id='delete".$row['id']."' href='".$_SERVER['PHP_SELF']."?delete&amp;id=".$row['id']."&country=".$country."'></a>
								<a class='admin_edit' title='Редактировать' href='".$_SERVER['PHP_SELF']."?edit&amp;id=".$row['id']."'></a>
								<a class='admin_open' title='Открыть' target='_blank' href='".$row['url']."'></a>
							</div>
							<div class='clear'></div>
							<script>
								$('#delete".$row['id']."').click(function() {
									var i = $(this).attr('href');
									if (confirm('Вы действительно хотите удалить?'))
									top.location.href=i;
									else return false;
								});
							</script>
							<div class='clear'></div>
						</div>
					</div>
				</div>
			</div>";
		}
		echo "</div>";

		echo $n->navi();
	}
}

echo $FOOTER;
?>
