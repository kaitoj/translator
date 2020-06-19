<?php

use Illuminate\Support\Facades\Route;

Route::get('translations',  'TranslationController@index')->name('translations');
Route::get('language/{lang}', 'TranslationController@change')->name('language');

            