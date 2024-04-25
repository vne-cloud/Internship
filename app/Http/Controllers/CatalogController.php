<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seo;
use App\Page;
use App\Catalog;
use App\Catalog_cat;

class CatalogController extends Controller
{
    //СПИСОК товаров
    public function catalog($url = null, Request $request) {

		$catalog_page = Page::where('show', 1)->where('id', 2)->first();

        //Каталог
        $catalog = $this->catalog_list($url, $request);

        //Крошки
        $catalog_cat = (object)[];
        $breadcrumbs = array();
        if (!empty($url)) {
            $catalog_cat = Catalog_cat::where('show', 1)->where('url', $url)->first();
            if (!$catalog_cat) abort(404);
            $breadcrumbs[] = array($catalog_page->name, '/'.$catalog_page->url);
            $breadcrumbs[] = array($catalog_cat->name);
        }
        else {
            $breadcrumbs[] = array($catalog_page->name);
        }

        return view('catalog.catalog', [
            'breadcrumbs' => $breadcrumbs,
            'catalog' => $catalog,
        ]);
    }

    //Список товаров каталога
    protected function catalog_list($url, $request) {
        $query = Catalog::Query();
        if (!empty($url)) $query->where('catalog_cat.url', $url);
		$catalog = $query->leftJoin('catalog_cat','catalog_cat.id', '=', 'catalog.catalog_cat')
            ->where('catalog.show', 1)
			->orderBy('catalog.rate', 'desc')
			->orderBy('catalog.id', 'asc')
            ->select('catalog.*', 'catalog_cat.url AS cat_url')
            ->get();
      	$catalog->admin = Seo::admin('/admin/modules/catalog.php', 'edits2');
        return $catalog;
    }

    //КАРТОЧКА товара / услуги / набора
    public function tovar($url, $tovar, Request $request) {

        //Страница каталога
		$catalog_page = Page::where('show', 1)->where('id', 2)->first();

        //Категория
        $catalog_cat = Catalog_cat::where('show', 1)
            ->where('url', $url)
            ->first();
        if (!$catalog_cat) abort(404);

        //Карточка
        $tovar = Catalog::where('show', 1)
            ->where('url', $tovar)
            ->first();
        if (!$tovar) abort(404);
        $tovar->admin = Seo::admin('/admin/modules/catalog.php?edit&id='.$tovar->id, 'edits2');

        //Крошки
        $breadcrumbs = array();
        $breadcrumbs[] = array($catalog_page->name, '/'.$catalog_page->url);
        $breadcrumbs[] = array($catalog_cat->name, '/'.$catalog_page->url.'/'.$catalog_cat->url);
        $breadcrumbs[] = array($tovar->name);

        return view('catalog.tovar', [
            'breadcrumbs' => $breadcrumbs,
            'tovar' => $tovar,
        ]);
    }
}
