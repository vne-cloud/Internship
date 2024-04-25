<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seo;
use App\Banner;

class IndexController extends Controller
{
	public function index() {

		//Ссылки на админку
		$admin = Seo::admin('/admin/setting/setting.php');

		//Баннеры верхние
		$banners = Banner::where('show', 1)
			->orderBy('rate', 'desc')
			->get();
		$banners->admin = Seo::admin('/admin/banners/banners.php');
		
		return view('index', [
			'admin' => $admin,
			'banners' => $banners,
		]);
	}
}
