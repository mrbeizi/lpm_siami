<?php

use Illuminate\Support\Facades\Route;

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
})->name('base');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('dashboard');

Route::group(['middleware' => 'auth'], function(){
    Route::resource('user-role', 'LPM\UserRoleController');
    Route::resource('data-user', 'UserController');
    Route::resource('data-auditee', 'LPM\AuditeeController');
    Route::resource('data-faculty', 'General\FacultyController');
    Route::resource('data-employee', 'General\EmployeeController');
    Route::resource('data-department', 'General\DepartmentController');

    Route::post('list-prodi','LPM\AuditeeController@prodi')->name('list-prodi');
});
