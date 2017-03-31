<?php

Route::get('db', 'TestingController@index');
Route::put('db', 'TestingController@save');
Route::put('db/restore', 'TestingController@reset');

Route::get('date', 'TestingController@date');
Route::put('date', 'TestingController@setDate');
Route::delete('date', 'TestingController@clearDate');
