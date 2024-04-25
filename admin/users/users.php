<?
require_once('../config.php');
echo $HEADER;

if(ADMIN <> "true")
{
	header("location: /admin");
	exit;
}

if(isset($_GET['edit']) || isset($_GET['add']))
{
	$id = dataprocessing($_GET['id']);
	$userresult = mysql_query("SELECT * FROM user WHERE id='".$id."' LIMIT 1");
	if (mysql_num_rows($userresult) <> 0 || isset($_GET['add']))
	{
		$row = mysql_fetch_array($userresult);

		$class = $row['class'];
		if (empty($class)) $class = 4;

		if($row['verified'] == 1) $ch = "checked='checked'";
		if (isset($_GET['add'])) $ch = "checked='checked'";

		$cl1 = "type-show";
		$cl2 = "";
		if ($row['type'] == 2) {
			$cl1 = "";
			$cl2 = "type-show";
		}

		$birthday = $row['birthday'] <> "" ? date('Y-m-d', strtotime($row['birthday'])) : "";

		$ava = "";
		if (!empty($row['ava'])) $ava = "<img src='/public/images/user/".$row['ava']."' style='max-width: 100%; border-radius: 100%; margin-bottom: 8px;'>";

		$lastvisit = $row['lastvisit'] <> "" ? date('d.m.Y H:i', $row['lastvisit']) : "";

		echo "<h1>".heads($row['login'], 'пользователя')."</h1>
		".BACK."
		<form action='".$_SERVER['PHP_SELF']."' method='post' enctype='multipart/form-data'>
			<div class='formbox formbox-big'>
				<div class='label'>Последний визит:</div>
				<div class='row'><strong>".$lastvisit."</strong></div>
				<div class='clear'></div>
			</div>
			<div class='formbox formbox-big'>
				".select('class', $class, 'Класс пользователя:', '', '', 'user_class', '', 'label2')."
				".select('type', $row['type'], 'Тип пользователя:', '', '', 'user_type', '', 'label2')."
				<div class='clear'></div>
			</div>
			<div class='formbox'>
				<fieldset>
					<legend>Основные данные</legend>
					".input('login', $row['login'], 'Логин (email):')."
					<div class='formbox'>
						<div class='label'>Пароль</div>
						<input type='text' id='password' name='password' value='' class='input'  maxlength='40' />
					</div>
				</fieldset>
			</div>
			<div class='formbox'>
				<fieldset>
					<legend>Контактная информация</legend>
					<div class='formbox'>
						<div class='label'>Телефон:</div>
						<div class='row'><strong>".$row['phone']."</strong></div>
						<div class='clear'></div>
					</div>
					<div class='formbox'>
						<div class='label'>E-mail:</div>
						<div class='row'><strong>".$row['email']."</strong></div>
						<div class='clear'></div>
					</div>
				</fieldset>
			</div>
			<div class='formbox'>
				<fieldset>
					<legend>Личная информация</legend>
					<div class='type ".$cl1."'>
						{$ava}
						".input('name', $row['name'], 'Имя:')."
						".input('lastname', $row['lastname'], 'Фамилия:')."
						".input('otch', $row['otch'], 'Отчество:')."
						<div class='formbox'>
							<div class='label'>Пол:</div>
							<div class='select select-wrap'>
								<select name='gender' class='input'>
									<option value='0'>Не выбрано</option>
									<option value='1' ".($row['gender'] == 1 ? "selected=selected" : "").">Мужской</option>
									<option value='2' ".($row['gender'] == 2 ? "selected=selected" : "").">Женский</option>
								</select>
							</div>
						</div>
						<div class='formbox'>
							<div class='label'>Дата:</div>
							<input type='date' name='birthday' value='".$birthday."' class='input' maxlength='255' />
						</div>
					</div>
					<div class='type ".$cl2."'>
						".input('company', $row['company'], 'Название компании:', '', 'label2')."
						".input('contact', $row['contact'], 'Контактное лицо:', '', 'label2')."
					</div>
				</fieldset>
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
	else $_SESSION['notice'] = "Изменено";
	$id = dataprocessing($_POST['id']);
	$login = dataprocessing($_POST['login']);
	$name = dataprocessing($_POST['name']);
	$lastname = dataprocessing($_POST['lastname']);
	$class = dataprocessing($_POST['class']);
	$password = dataprocessing($_POST['password']);
	$type = dataprocessing($_POST['type']);
	$company = dataprocessing($_POST['company']);
	$contact = dataprocessing($_POST['contact']);
	$gender = dataprocessing($_POST['gender']);
	$birthday = dataprocessing($_POST['birthday']);
	if (!empty($birthday)) $birthday = date('d.m.Y', strtotime($birthday));

	$seachuser = mysql_query("SELECT * FROM user WHERE login='".$login."' AND id<>'".$id."' LIMIT 1");
	if (mysql_num_rows($seachuser))	{
		$_SESSION['notice'] = "Пользователь с таким логином уже существует";
		header("location: ".$_SERVER['PHP_SELF']."?id=".$id."&edit");
		exit;
	}

	$str = "`login`='{$login}'
	, `class`='{$class}'
	, `type`='{$type}'
	, `name`='{$name}'
	, `lastname`='{$lastname}'
	, `company`='{$company}'
	, `contact`='{$contact}'
	, `gender`='{$gender}'
	, `birthday`='{$birthday}'
	";

	if (isset($_POST['add'])) {
		$time = time();
		mysql_query("INSERT INTO user SET
			{$str}
			, `lastvisit`='{$time}'
		");
		$id = mysql_insert_id();
	}
 	else {
		mysql_query("UPDATE user SET ".$str." WHERE id='".$id."'");
	}

	//новый пароль
	if(!empty($password))	{
		$sault = md5(uniqid(rand(), true));
		$password = md5($sault.$password);
		mysql_query("UPDATE user SET
			`password`='{$password}'
			, `sault`='{$sault}'
			WHERE id='{$id}'
		");
		if($login == $username) {
			setcookie("user", $login."|".$password , time() + 1209600, "/", $_SERVER['SERVER_NAME'], "0");
			$_SESSION['user'] = $login."|".$password;
		}
	}

	header("location: ".$_SERVER['PHP_SELF']."?edit&id=".$id."");
	exit;
}
else if(isset($_GET['delete']) && isset($_GET['id']))
{
	$id = dataprocessing($_GET['id']);
	mysql_query("DELETE FROM user WHERE id='".$id."'");

	$_SESSION['notice'] = "Пользователь удалён";

	header("location: ".$_SERVER['PHP_SELF']."");
}
else
{
	echo "<h1>Пользователи</h1>
	".SITE;

	//поиск
	$search = $where = "";
	if(!empty($_GET['search'])) {
		$search = adataprocessing($_GET['search']);
		$where .= " AND (u.login LIKE '%".$search."%' OR u.name LIKE '%".$search."%')";
	}

	//класс
	$user_class = adataprocessing($_GET['user_class']);
	if(!empty($user_class)) {
		$where .= " AND u.class = '".$user_class."'";
	}

	//тип
	$user_type = adataprocessing($_GET['user_type']);
	if(!empty($user_type)) {
		$where .= " AND u.type = '".$user_type."'";
	}

	echo "<div class='filter'>
		<div class='filterHead'>Фильтр</div>
		<form name='' action='".$_SERVER['PHP_SELF']."' method='GET'>
			<div class='formbox-left'>
				<div class='formbox'>
					<input type='text' name='search' value='".$search."' class='input input-all input-all-50 filt-all' maxlength='255' placeholder='Введите логин или ФИО' />
					<input type='submit' name='submit' class='button submit-all' value='Поиск' />
					<div class='clear'></div>
				</div>
			</div>
			<div class='formbox-right'>
				".select_filt('user_class', $user_class, 'Класс:', '')."
			</div>
			<div class='clear' style='height: 10px;'></div>
		</form>
	</div>";

	echo "<a href='".$_SERVER['PHP_SELF']."?add' class='add'><span>Добавить пользователя</span></a>";

	echo "<div class='listContent'>";

		$query = "SELECT u.*, s.name s_name, t.name t_name
		FROM user u
		LEFT JOIN user_class s ON s.id = u.class
		LEFT JOIN user_type t ON t.id = u.type
		WHERE 1=1 ".$where;

		$sq = mysql_query($query);
		$all = mysql_num_rows($sq);
		if ($all) {
			echo "<table class='table tablesorter'>
				<thead>
					<tr>
						<th class='tr-hide'>ID</th>
						<th>Логин</th>
						<th>ФИО / <br>Данные компании</th>
						<th>Класс пользователя</th>
						<th>Тип пользователя</th>
						<th>Телефон</th>
						<th>Email</th>
						<th></th>
					</tr>
				</thead>
				<tbody>";

				$pnumber = 100;
				$n = new Navigator($all, $pnumber, "");
				$q = mysql_query($query." ORDER BY u.id DESC LIMIT ".$n->start().",$pnumber");
				while ($row = mysql_fetch_array($q)) {

					$names = $row['name']."<br>".$row['lastname'];
					if ($row['type'] == 2) $names = $row['company']."<br>".$row['contact'];

					$st = "";
					if ($row['class'] == 1) $st = "background: #f7ffea;";

					$stt = "color: #042b92;";
					if ($row['type'] == 2) $stt = "color: #b10000;";

					echo "<tr style='{$st}'>
						<td class='tr-hide'>".$row['id']."</td>
						<td><span class='tr-bold'>".$row['login']."</span></td>
						<td>{$names}</td>
						<td>".$row['s_name']."</td>
						<td><div style='".$stt."'>".$row['t_name']."</div></td>
						<td>".$row['phone']."</td>
						<td>".$row['email']."</td>
						<td style='min-width: 80px;'>";
							echo "<a class='admin_del delete-all' href='".$_SERVER['PHP_SELF']."?delete&id=".$row['id']."' title='Удалить'></a>
							<a class='admin_edit' title='Редактировать' href='".$_SERVER['PHP_SELF']."?edit&id=".$row['id']."'></a>";
						echo "</td>
					</tr>";
				}

			echo "</tbody>
			</table>";
		}
		else {
			echo "<div class='formbox_show'>Ничего не найдено</div>";
		}

	echo "</div>";

	if ($all) echo $n->navi();
}

echo $FOOTER;
?>
