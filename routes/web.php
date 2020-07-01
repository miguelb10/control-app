<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//$empresa = '/';

Route::get('/', 'HomeController@index')->name('home');
Route::get('/invoices', 'InvoiceController@Index')->name('invoices.filter');
Route::post('/invoices', 'InvoiceController@Update')->name('invoices.download');

Auth::routes(['register' => false,
'password/confirm' => false,
'password/email' => false,
'password/reset' => false,]);

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/home', 'HomeController@change')->name('home.change');
Route::get('/home', 'HomeController@Index')->name('homee');

Route::get('/employees', 'EmployeeController@Index')->name('employees');
Route::post('/employees', 'EmployeeController@Update')->name('employees.update');

Route::get('/employees/{employee}', 'EmployeeController@Show')->name('employee.show');

Route::get('/logs', 'LogController@Index')->name(('logs'));
Route::get('/downloads', 'LogController@Index')->name(('logs.sho'));
Route::post('/downloads', 'LogController@Show')->name(('logs.show'));

Route::get('/profile', 'ProfileController@Index')->name('profile');
Route::post('/profile','ProfileController@Update')->name('profile.update');
