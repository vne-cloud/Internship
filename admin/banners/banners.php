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
	$result=mysql_query("SELECT * FROM banners WHERE id='".$id."' LIMIT 1");
	if(mysql_num_rows($result)<>0 || isset($_GET['add']))
	{
		$row=mysql_fetch_array($result);

		if($row['show'] == 1) $ch = "checked='checked'";
		else $ch = "";

		$head = "Редактирование";
		if (isset($_GET['add'])) {
			$ch = "checked='checked'";
			$head = "Добавление";
		}

		echo "<h1>".$head." баннера</h1>
		".BACK."
		".SITE."
		<form action='".$_SERVER['PHP_SELF']."' method='post'  enctype='multipart/form-data'>
			<div class='formbox'>
				<div class='label'>На сайте:</div>
				<div class='row'>
					".checkbox('show', $ch)."
					Показывать
				</div>
			</div>
			".image('', 'Баннер', 'размеры 969x430px', $row, 'banners')."
			".input('url', $row['url'], 'Ссылка с баннера:')."
			".input('rate', $row['rate'], 'Рейтинг:')."
			<div class='formbox_submit'>
				<div class='formbox_submit'>";
				if (isset($_GET['add']))
					echo "<input name='add' type='submit' value='".SEND."' class='button' />";
				else {
					echo "<input type='hidden' name='id' value='".$id."' />
					<input name='edit' type='submit' value='".SEND."' class='button' />";
				}
			echo "</div>
			</div>
		</form>";
	}
}
else if(isset($_POST['edit']) || isset($_POST['add']))
{
	if (isset($_POST['add'])) $_SESSION['notice'] = 'Добавлено';
	else $_SESSION['notice'] = "Успешно сохранено";
	$id = dataprocessing($_POST['id']);
	$show = dataprocessing($_POST['show']);
	$url = dataprocessing($_POST['url']);
	$head = adataprocessing($_POST['head']);
	$text = adataprocessing($_POST['text']);
	$rate = adataprocessing($_POST['rate']);

	chdir("../../public/images/banners/");
	$count = time();

	$img1 = image_upload('', 'marks', 969, 430);

	$str = "`show`='".$show."'
		, `url`='".$url."'
		, `head` = '".$head."'
		, `text` = '".$text."'
		, `rate` = '".$rate."'
		".$img1."
	";

	if (isset($_POST['add'])) {
		mysql_query("INSERT INTO banners SET
			".$str."
		");
		$id = mysql_insert_id();
	}
 	else {
		mysql_query("UPDATE banners SET
			".$str."
			WHERE id='".$id."'
		");
	}

	header("location: ".$_SERVER['PHP_SELF']."?edit&id=".$id."");
	exit;
}
else if(isset($_GET[delete]))
{
	$_SESSION['notice'] = "Баннер удалён";
	$id = dataprocessing($_GET['id']);
	chdir("../../images/banners/");
	$ress = mysql_query("SELECT * FROM banners WHERE id='".$id."'");
	$rows = mysql_fetch_array($ress);
	unlink(trim($rows['path']));
	mysql_query("DELETE FROM banners WHERE id='".$id."'");

	header("location: ".$_SERVER['PHP_SELF']."?show");
	exit;
}
else
{
	echo "<h1>Баннеры</h1>
	".SITE."
	<a href='".$_SERVER['PHP_SELF']."?add' class='add'><span>Добавить баннер</span></a>";

	$sq=mysql_query("SELECT * FROM banners");
	$all=mysql_num_rows($sq);
	if ($all)
	{
		echo "<div class='listContent'>";

		$pnumber = 30;
		$n = new Navigator($all, $pnumber, "");
		$q=mysql_query("SELECT * FROM banners ORDER BY rate DESC, id ASC LIMIT ".$n->start().",$pnumber");
		echo $n->navi();
		while ($row=mysql_fetch_array($q))
		{
			$cl = "";
			if($row['show'] == 1) $cl = "admin_show_act";

			echo "<div class='formbox_show'>
				<div class='vtable'>
					<div class='vrow'>
						<div class='vcell'>
							<div class='show_name'>
								<img src='/images/banners/".$row['path']."' alt='' style='max-width: 465px;' />
							</div>
						</div>
						<div class='vcell'>
							<div class='admins'>
								<a class='admin_del' title='Удалить' id='delete".$row['id']."' href='".$_SERVER['PHP_SELF']."?delete&amp;id=".$row['id']."&country=".$country."'></a>
								<a class='admin_edit' title='Редактировать' href='".$_SERVER['PHP_SELF']."?edit&amp;id=".$row['id']."'></a>
								<div class='admin_show ".$cl."' title='Показывать на сайте' data-id='".$row['id']."' data-table='banners'></div>
								<a class='admin_open' title='Открыть' target='_blank' href='/'></a>
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
