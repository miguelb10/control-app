<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$empresa = '/crt';

Route::get($empresa, 'HomeController@index')->name('home');
Route::get($empresa.'/invoices', 'InvoiceController@Index')->name('invoices.filter');
Route::post($empresa.'/invoices', 'InvoiceController@Update')->name('invoices.download');

Auth::routes(['register' => false,
'password/confirm' => false,
'password/email' => false,
'password/reset' => false,]);

Route::get($empresa.'/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post($empresa.'/login', 'Auth\LoginController@login');
Route::post($empresa.'/logout', 'Auth\LoginController@logout')->name('logout');
Route::post($empresa.'/home', 'HomeController@change')->name('home.change');

Route::get($empresa.'/employees', 'EmployeeController@Index')->name('employees');
Route::post($empresa.'/employees', 'EmployeeController@Update')->name('employees.update');

Route::get($empresa.'/employees/{employee}', 'EmployeeController@Show')->name('employee.show');

Route::get($empresa.'/logs', 'LogController@Index')->name(('logs'));
Route::get($empresa.'/downloads', 'LogController@Index')->name(('logs.sho'));
Route::post($empresa.'/downloads', 'LogController@Show')->name(('logs.show'));

Route::get($empresa.'/profile', 'ProfileController@Index')->name('profile');
Route::post($empresa.'/profile','ProfileController@Update')->name('profile.update');
