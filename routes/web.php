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

// Route::get('/home', 'HomeController@index')->name('dashboard');
Route::group(['middleware' => ['auth', 'checkrole:1,2,3,4']], function() {
    Route::post('/logout', 'Auth\AuthController@logout')->name('logout');
    Route::get('/redirect', 'RedirectController@cek');
});

// superadmin or lpm
Route::group(['middleware' => ['auth', 'checkrole:1']], function() {
    Route::get('/lpm', 'LPM\DashboardController@index')->name('dashboard');
    Route::resource('user-role', 'LPM\UserRoleController');
    Route::resource('data-user', 'UserController');
    Route::resource('data-auditee', 'LPM\AuditeeController');
    Route::resource('data-faculty', 'General\FacultyController');
    Route::resource('data-employee', 'General\EmployeeController');
    Route::resource('data-department', 'General\DepartmentController');
    
    Route::post('list-prodi','LPM\AuditeeController@prodi')->name('list-prodi');

    Route::resource('data-auditor', 'Auditors\AuditorController');
    Route::resource('data-announcement', 'General\AnnouncementController');
    Route::resource('data-news', 'General\NewsController');
    Route::resource('data-period', 'General\PeriodController');
    Route::post('switch-period','General\PeriodController@switchPeriode')->name('change-period-status');
    Route::post('switch-period-main','General\PeriodController@switchPeriodeMain')->name('switch-period-main');

    Route::get('standard-tree','General\PeriodController@index')->name('standard-tree');

    Route::get('standard-tree-view',['as'=>'index.standard','uses'=>'General\StandardController@manageStandard']);
    Route::post('add-standard',['as'=>'add.standard','uses'=>'General\StandardController@addStandard']);

    Route::resource('data-standard-period', 'General\StandardPeriodController');
    Route::post('switch-standard-period','General\StandardPeriodController@switchPeriode')->name('switch-standard-period');
    Route::post('archived-std','General\StandardPeriodController@archiveStd')->name('archiveStd');
    Route::get('/add-std/{id}','General\StandardController@manageStandard')->name('setting.std');
    Route::get('index-standard-1','General\StandardController@indexStandard')->name('index.standard-1');
    Route::delete('delete-standard-1','General\StandardController@deleteStandard')->name('delete.standard-1');

    Route::resource('data-schedule','LPM\ScheduleController');
    Route::post('send-id-auditee','LPM\ScheduleController@getIdAuditee')->name('send-id-auditee');

    Route::resource('data-assignment-letter','LPM\AssignmentLetterController');
    Route::get('download-assignment-letter/{id}','LPM\AssignmentLetterController@downloadAssignmentLetter')->name('download-assignment-letter');

    Route::get('/auditor', 'Auditors\DashboardController@index');
    Route::resource('data-document', 'ImplementationDocs\DocumentController');
    Route::post('archived-doc','ImplementationDocs\DocumentController@archiveDoc')->name('archiveDoc');
    Route::resource('ami-implementation','ImplementationDocs\DashboardDocsController');
    Route::get('list-faculties/{id}','ImplementationDocs\DashboardDocsController@faculties')->name('list-faculties');
    Route::resource('data-doc-spmi','LPM\DocumentSpmiController');
});

// auditor
Route::group(['middleware' => ['auth', 'checkrole:2']], function() {
    Route::get('/auditor', 'Auditors\DashboardController@index');
    Route::resource('a-data-document', 'Auditors\DocumentController');
    Route::post('a-archived-doc','Auditors\DocumentController@archiveDoc')->name('a-archiveDoc');
    Route::resource('a-ami-implementation','Auditors\DashboardDocsController');
    Route::get('a-list-faculties/{id}','Auditors\DashboardDocsController@faculties')->name('a-list-faculties');
});

// faculty
Route::group(['middleware' => ['auth', 'checkrole:3']], function() {
    Route::get('/fakultas', 'Faculty\DashboardController@index');
});

// rectorat
Route::group(['middleware' => ['auth', 'checkrole:4']], function() {
    Route::get('/rektorat', 'Rectorat\DashboardController@index');
});