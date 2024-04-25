<?php
namespace App;

class Helper
{
	public static function phone($val) {
		$val = str_replace(" ", "", $val);
		$val = str_replace("(", "", $val);
		$val = str_replace(")", "", $val);
		$val = str_replace("-", "", $val);

		return $val;
	}
	
	public static function decl($number, $titles) {
		$cases = array (2, 0, 1, 1, 1, 2);
		return $titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
	}
	
	public static function month($date, $short = "") {
		$arr = array();
		$arr[] = 'января';
		$arr[] = 'февраля';
		$arr[] = 'марта';
		$arr[] = 'апреля';
		$arr[] = 'мая';
		$arr[] = 'июня';
		$arr[] = 'июля';
		$arr[] = 'августа';
		$arr[] = 'сентября';
		$arr[] = 'октября';
		$arr[] = 'ноября';
		$arr[] = 'декабря';

		$day = "";
		if (!empty($date)) {
			$day = date('d', $date)." ".$arr[date('n', $date) - 1];
		}

		if ($short == 1) {
			$day = $arr[date('n', $date) - 1];
		}

		return $day;
	}
	
	public static function format($val) {
		$val = sprintf("%06d", $val);
		return $val;
	}
	
	public static function format_price($price) {
		$price = number_format($price, 0, ' ', ' ');
		return $price;
	}
	
	public static function image($filename) {

		$filename = strtolower($filename);
		$path_info = pathinfo($filename);
		$extension = $path_info['extension'];

		$arr = array('jpg', 'jpeg', 'png', 'gif', 'svg');
		if (in_array($extension, $arr)) $img = 1;
		else $img = 0;

		/*$blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm", ".js");
		foreach ($blacklist as $item) {
			if(preg_match("/$item\$/i", $filename)) $img = 0;
		}*/

		return $img;
	}
	
	public static function mailer($to, $subject, $message, $files = "") {

		//$server_mail = "";
		//$server_pass = "";

		if (empty($to)) return;

		require_once('PHPMailer.php');
		$mail = new PHPMailer;
		$mail->CharSet = 'UTF-8';

		//ЧЕРЕЗ SMTP
		/*$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPDebug = 0;

		$mail->Host = "ssl://smtp.yandex.ru";
		$mail->Port = 465;
		$mail->Username = $server_mail;
		$mail->Password = $server_pass;*/

		// От кого
		//$mail->setFrom($server_mail, $_SERVER['SERVER_NAME']);

		/*$res = mysql_query("SELECT * FROM `setting` WHERE id = '1'");
		$row = mysql_fetch_array($res);
		$from = $row['mail'];*/

		$server_name = $_SERVER['SERVER_NAME'];
		$from = "info@".$server_name;

		$mail->setFrom($from, $server_name);

		if (empty($reply)) $reply = $from;
		$mail->AddReplyTo($reply, $server_name);

		// Кому
		$to_arr = explode(',', $to);
		foreach($to_arr AS $to_mail) {
			$to_mail = trim($to_mail);
			if (!empty($to_mail)) {
				$mail->addAddress($to_mail, '');
			}
		}

		// Тема письма
		$mail->Subject = $subject;

		// Тело письма
		$mail->msgHTML($message);

		// Приложение
		//$mail->addAttachment(__DIR__ . '/image.jpg');
		if (!empty($files)) {
			foreach($files AS $file) {
				$mail->addAttachment($file);
			}
		}

		// Результат
		if(!$mail->send()) {
			return $mail->ErrorInfo;
		}
		else {
			return 1;
		}
	}
	
	public static function mails($to, $subject, $message) {

		if (empty($to) || empty($subject) || empty($message)) return;

		$server_name = $_SERVER['SERVER_NAME'];
		$from = "info@".$server_name;

		$to = $to."\n";
		$subject = "=?utf-8?B?".base64_encode($subject)."?= \n";
		$from = "=?utf-8?B??= <{$from}> \n";

		$send = mail($to, $subject, $message,
			"Content-type: text/html; charset=utf-8 \n".
			"from: {$from}"
		);
		return $send;
	}
}

?>
