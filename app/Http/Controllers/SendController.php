<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Send;
use App\Mail;

class SendController extends Controller
{
    public function send(Request $request) {

        $setting = Setting::All()->first();
		$method = @$request->method;
        $url = @$request->url;

        if (empty($method)) return;

        switch($method) {
            case 'feed':
                $name = @$request->name;
                $phone = @$request->phone;
                $email = @$request->email;
                $subject = 'Новая заявка';
                $message = "<strong>Новая заявка</strong> от посетителя ".$_SERVER['SERVER_NAME']."<br><br>
                <strong>Со страницы:</strong> ".$url."<br />
                <strong>Имя:</strong> ".$name."<br />
                <strong>Телефон:</strong> ".$phone."<br />
                <strong>E-mail:</strong> ".$email."<br />";
            break;
        }

        if (!empty($subject)) {

            //письмо
            $to = $setting->mailsend;
            Mail::send($to, $subject, $message);

            //в базу
            $send = new Send();
            $send->type = $subject;
            $send->name = @$name;
            $send->phone = @$phone;
            $send->mail = @$email;
            $send->text = @$text;
            $send->url = @$url;
            $send->date = time();
            $send->save();

            return 1;
        }
    }
}
