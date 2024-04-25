<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Setting;
use App\Page;
use App\Seo;
use App\User;
use App\Cookie;

class AppServiceProvider extends ServiceProvider
{
    //Bootstrap any application services.
    public function boot(Request $request)
    {
        //SEO
		Seo::meta($request);

        //Проверка залогинен ли
        $user = User::check();
		if (empty($user)) $user = (object)[];
        View::share('user', $user);

        //Страницы
        $pages = Page::where('show', 1)
                ->orderBy('rate', 'desc')
                ->orderBy('id', 'asc')
                ->get();
        View::share('pages', $pages);

        foreach ($pages AS $page) {
            $page->admin = Seo::admin('/admin/pages/page.php?edit&id='.$page->id, '', false);
            View::share('page'.$page->id, $page);
        }

		//Все настройки из базы
		$setting = Setting::All()->first();
		View::share('setting', $setting);

        //alert в окне
        $message = Cookie::processing(@$_SESSION['message']);
        if (!empty($message)) {
            unset($_SESSION['message']);
            View::share('message', $message);
        }
    }

    //Register any application services.
    public function register()
    {
        //
    }
}
