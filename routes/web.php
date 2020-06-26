<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home1');
Route::get('/invoices', 'InvoiceController@Index')->name('invoices');
Route::get('/invoices', 'InvoiceController@Index')->name('invoices.filter');
Route::post('/invoices', 'InvoiceController@Update')->name('invoices.download');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home2');

Route::get('/employees', 'EmployeeController@Index')->name('employees');
Route::post('/employees', 'EmployeeController@Update')->name('employees.update');

Route::get('/employees/{employee}', 'EmployeeController@Show')->name('employee.show');

Route::get('/logs', 'LogController@Index')->name(('logs'));
Route::post('/logs', 'LogController@Show')->name(('logs.show'));

Route::get('/profile', 'ProfileController@Index')->name('profile');
Route::post('/profile','ProfileController@Update')->name('profile.update');
