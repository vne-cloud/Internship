<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cookie;

class User extends Model
{
    protected $table = 'user';

	public $timestamps = false;

    public static function check(){

        $ADMIN = false;
        $USER_ID = 0;
        $user = (object)[];
        $user->logged = false;

        $cookie = Cookie::get('user');
        if (!empty($cookie)) {
            $cookie = explode("|",$cookie);
            $login = $cookie['0'];
            $password = $cookie['1'];

            $user = self::where('login', $login)
                ->where('password', $password)
                ->first();

            if ($user) {
                if ($user->class == 1) $ADMIN = true;
                $USER_ID = $user->id;

                $user->lastvisit = time();
                $user->save();

                $user->logged = 1;
            }
            else {
                Cookie::del('user');
            }
        }

        if (!defined('ADMIN')) {
            define("ADMIN", $ADMIN);
        }
        if (!defined('USER_ID')) {
            define("USER_ID", $USER_ID);
        }

        return $user;
    }
}
