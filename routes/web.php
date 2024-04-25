<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//Главная
Route::get('/', 'IndexController@index')->name('index');

//Каталог
Route::get('/catalog/{url}/{tovar}', 'CatalogController@tovar');
Route::get('/catalog/{url?}', 'CatalogController@catalog');

//Заявки
Route::post('/send', 'SendController@send');

//Страницы
Route::get('/{url}', 'PageController@page');
