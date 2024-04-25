<?php
namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
	public static function send($to, $subject, $message) {

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

	public static function sends($to, $subject, $message, $files = "") {

		if (empty($to)) return;

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
}

?>
