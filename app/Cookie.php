<?php
namespace App;

class Cookie
{
	public static function set($name, $val, $time = "") {
		if (empty($val)) return;

		if (empty($time)) {
			$time = time() + 3600 * 24 * 30; //по умолчанию на месяц
		}

		setcookie($name, $val, $time, "/", $_SERVER['SERVER_NAME'], "0");
	}

	public static function get($name) {
		$val = @$_COOKIE[$name];
		$val = self::processing($val);
		return $val;
	}
	
	public static function del($name) {
		$time = 3600 * 24 * 30 * 2; //минус 2 месяца
		setcookie($name, '', time() - $time, "/", $_SERVER['SERVER_NAME'], "0");
	}
	
	public static function processing ($value) {
		$value = trim($value);
		$value = preg_replace("/[\r\n]{3,}/i", "\r\n\r\n", $value);
		$value = stripslashes($value);
		return $value;
	}
}

?>
