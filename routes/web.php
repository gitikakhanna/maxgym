<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/add-member', 'CustomerController@index');
Route::post('/customer/add', 'CustomerController@store');
Route::post('/customer/update/{id}', 'ViewcustomerController@update');
Route::get('/customer/delete/{id}', 'ViewcustomerController@delete');
Route::get('/member-profile/view', 'ViewcustomerController@index');

Route::get('/packages', 'PackageController@index');
Route::get('/packages/view', 'PackageController@create');
Route::get('/packages/delete/{id}', 'PackageController@delete');
Route::post('/packages/add', 'PackageController@store');
Route::post('/packages/update/{id}', 'PackageController@update');

Route::post('/notification/update/{customer}/{name}/{id}', 'NotificationsController@update');
Route::get('/notification/dismiss/{id}', 'NotificationsController@delete');
Route::get('/invoice/log/view/{id}', 'InvoiceController@index');

Route::get('/send/send_email', 'HomeController@sendmail');
Route::get('/test', 'TestController@index');

Route::get('/trainer', 'TrainerController@index');

Route::post('/trainer/add', 'TrainerController@store');
Route::post('/trainer/update/{id}', 'TrainerController@update');
Route::get('/trainer/delete/{id}', 'TrainerController@delete');

Route::get('/attendance', 'AttendanceController@index');
Route::post('/attendance/mark', 'AttendanceController@store');

Route::get('/attendance/marking/log/{trainerid}', 'AttendanceController@create');

Route::get('/mail_template', 'TestController@create');