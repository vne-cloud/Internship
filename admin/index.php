<?
require_once('config.php');


echo $IHEADER;

if(isset($_GET['destroy']))
{
	if(isset($_COOKIE['user'])) 
	{
		setcookie("user", "", time() - 7200, "/", $_SERVER['SERVER_NAME'], "0");
	}
	session_destroy();
	
	header("location: /admin");
	exit;
}
else if(isset($_POST['enter']))
{
	$login = dataprocessing($_POST['login']);
	$password = dataprocessing($_POST['password']);
	$seachuser = mysql_query("SELECT * FROM user WHERE login='".$login."' LIMIT 1");
	if(mysql_num_rows($seachuser) == 0)
	{
		$_SESSION['notice'] = "Логин не зарегистрирован";
		header("location: /admin");
		exit;	
	}
	else
	{
		$seachuser_result = mysql_fetch_array($seachuser);
		$sault = $seachuser_result['sault'];
		$class = $seachuser_result['class'];
		$password = md5($sault.$password);		print_r($seachuser_result);
		if ($password <> $seachuser_result['password'])
		{
			$_SESSION['notice'] = "Неверный пароль";
			header("location: /admin");
			exit;
		}
		else
		{
			setcookie("user", $seachuser_result['login']."|".$seachuser_result['password'] , time() + 1209600, "/", $_SERVER['SERVER_NAME'], "0");
			$_SESSION['user'] = $seachuser_result['login']."|".$seachuser_result['password'];

			header("location: /admin");
			exit;			
		}
	}
}
else if(ADMIN == "true" || MODER == "true" || MODER2 == "true")
{
	$_SESSION['notice'] = "";
	header("location: /admin/desktop/desktop.php");
	exit;
}
else 
{
	echo "<form action='/admin/index.php' method='post'>
		<div class='enterHead'>Авторизация</div>
		<div class='formbox'>
			<div class='formLabel'>Логин:</div>
			<input type='text' name='login' value='' class='input_index' maxlength='40' autocomplete='off' />
		</div>
		<div class='formbox'>
			<div class='formLabel'>Пароль:</div>
			<input type='password' name='password' value='' class='input_index' maxlength='40' autocomplete='off' />
		</div>
		<div class='formbox_submit'>
			<input name='enter' type='submit' value='Войти' class='button' />
		</div>
	</form>";
}


echo $IFOOTER;

?>