<?
require_once('../config.php');
echo $HEADER;
if(ADMIN <> "true" && MODER <> "true")
{
	header("location: /admin");
	exit;
}


if(isset($_POST['edit']))
{
	$_SESSION['notice'] = "Изменения внесены";
	$site_name = dataprocessing($_POST['site_name']);
	$phone = dataprocessing($_POST['phone']);
	$phone2 = dataprocessing($_POST['phone2']);
	$phone3 = dataprocessing($_POST['phone3']);
	$phone_pre = dataprocessing($_POST['phone_pre']);
	$phone_pre2 = dataprocessing($_POST['phone_pre2']);
	$phone_pre3 = dataprocessing($_POST['phone_pre3']);
	$mail = dataprocessing($_POST['mail']);
	$mailsend = dataprocessing($_POST['mailsend']);
	$soc1 = dataprocessing($_POST['soc1']);
	$soc2 = dataprocessing($_POST['soc2']);
	$soc3 = dataprocessing($_POST['soc3']);

	$menu = dataprocessing($_POST['menu']);
	$view = dataprocessing($_POST['view']);
	$font = dataprocessing($_POST['font']);
	$light = dataprocessing($_POST['light']);

	mysql_query("UPDATE `setting` SET
		  `site_name`='".$site_name."'
		, `phone`='".$phone."'
		, `phone2`='".$phone2."'
		, `phone3`='".$phone3."'
		, `phone_pre`='".$phone_pre."'
		, `phone_pre2`='".$phone_pre2."'
		, `phone_pre3`='".$phone_pre3."'
		, `mail`='".$mail."'
		, `mailsend`='".$mailsend."'
		, `soc1`='".$soc1."'
		, `soc2`='".$soc2."'
		, `soc3`='".$soc3."'
		WHERE id='1'");

	$menu = dataprocessing($_POST['menu']);
	$view = dataprocessing($_POST['view']);
	$font = dataprocessing($_POST['font']);
	$light = dataprocessing($_POST['light']);

	mysql_query("UPDATE user SET
		menu = '".$menu."'
		, view = '".$view."'
		, font = '".$font."'
		, light = '".$light."'
	WHERE id = '".USER_ID."'");

	header("location: ".$_SERVER['PHP_SELF']."");
	exit;
}
else
{
	$result=mysql_query("SELECT * FROM `setting` WHERE id='1' LIMIT 1");
	if(mysql_num_rows($result)<>0)
	{
		$row = mysql_fetch_array($result);

		$ures = mysql_query("SELECT * FROM user WHERE id = '".USER_ID."'");
		$urow = mysql_fetch_array($ures);

		if($urow['menu'] == 1) $mch = "checked='checked'";
		else $mch = "";

		if($urow['view'] == 1) $vch = "checked='checked'";
		else $vch = "";

		if($urow['font'] == 1) $fch = "checked='checked'";
		else $fch = "";

		if($urow['light'] == 1) $lch = "checked='checked'";
		else $lch = "";

		echo "<h1>Редактирование: Настройки</h1>
		<a href='/' target='_blank' class='contentShow'>Посмотреть на сайте</a>
		<form action='".$_SERVER['PHP_SELF']."' method='post' enctype='multipart/form-data'>
			<div class='formbox'>
				<div class='label'>Вид админки:</div>
				<div class='row'>
					<div>
						".checkbox('menu', $mch)."
						Компактное меню
					</div>
					<div>
						".checkbox('view', $vch)."
						Компактный вид
					</div>
					<div>
						".checkbox('light', $lch)."
						Светлое меню
					</div>
				</div>
				<div class='clear'></div>
			</div>
			".input('site_name', $row['site_name'], 'Название сайта:', 'required')."
			<div class='formbox'>
				<fieldset>
					<legend>Контактные данные</legend>
					<div class='formbox'>
						<div class='label'>Телефон основной:</div>
						<input type='text' name='phone_pre' value='{$row['phone_pre']}' class='input' maxlength='255' style='width: 80px;'>
						<input type='text' name='phone' value='{$row['phone']}' class='input' maxlength='255' style='width: 150px;'>
					</div>
					<div class='formbox'>
						<div class='label'>Телефон 2:</div>
						<input type='text' name='phone_pre2' value='{$row['phone_pre2']}' class='input' maxlength='255' style='width: 80px;'>
						<input type='text' name='phone2' value='{$row['phone2']}' class='input' maxlength='255' style='width: 150px;'>
					</div>
					<div class='formbox'>
						<div class='label'>Телефон 3:</div>
						<input type='text' name='phone_pre3' value='{$row['phone_pre3']}' class='input' maxlength='255' style='width: 80px;'>
						<input type='text' name='phone3' value='{$row['phone3']}' class='input' maxlength='255' style='width: 150px;'>
					</div>
					".input('mail', $row['mail'], 'E-mail для отображения:')."
					".input('mailsend', $row['mailsend'], 'E-mail для сообщений:')."
				</fieldset>
			</div>
			<fieldset>
				<legend>Ссылки на соц. сети</legend>
				".input('soc1', $row['soc1'], 'Вконтакте:')."
				".input('soc2', $row['soc2'], 'Facebook:')."
				".input('soc3', $row['soc3'], 'Instagram:')."
			</fieldset>
			<div class='formbox_submit'>
				<input name='edit' type='submit' value='".SEND."' class='button' />
			</div>
		</form>";
	}
}
echo $FOOTER;
?>
