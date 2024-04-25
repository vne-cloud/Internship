<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seo;
use App\Page;

class PageController extends Controller
{
    public function page($url, Request $request) {

        $page = Page::where('url', $url)
                   ->orderBy('id', 'desc')
                   ->first();
        if(!$page) abort(404);
      	$page->admin = Seo::admin('/admin/pages/page.php?edit&id='.$page->id, 'edits2');

        //Крошки
        $breadcrumbs = array();
        $breadcrumbs[] = array($page->name);

        return view('page.page', [
            'page' => $page,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
