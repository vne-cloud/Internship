<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Setting;

class Seo extends Model
{
	protected $table = 'seo';

	public static function meta(Request $request){

		// со строкой запроса...
		$url = "/".$request->path();
		if ($request->path() == "/") $url = "/";

		//Все настройки из базы
		$setting = Setting::All()->first();
		$title = $keywords = $description = $setting->site_name;

		$seo = Seo::where('url', $url)->first();
		if ($seo) {
			if (!empty($seo->title)) $title = $seo->title;
			if (!empty($seo->keywords)) $keywords = $seo->keywords;
			if (!empty($seo->description)) $description = $seo->description;
			$editseo = "<a href='/admin/seo/seo.php?edit&id=".$seo->id."' target='_blank' class='edit'>SEO</a>";
		}
		else {
			$editseo = "<a href='/admin/seo/seo.php?add&url=".$url."' target='_blank' class='edit'>SEO</a>";
		}

		//Передача во все представления
		View::share('title', $title);
		View::share('keywords', $keywords);
		View::share('description', $description);
		View::share('editseo', $editseo);
	}
	
	//ссылки на админку
    public static function admin($href, $class = "", $seo = "") {

        $seo = 1;

        if (@ADMIN <> 'true') return;

        return view('setting.admin', [
            'href' => $href,
            'class' => $class,
            'seo' => $seo
        ]);
    }
}
