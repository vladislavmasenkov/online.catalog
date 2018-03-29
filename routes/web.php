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
Auth::routes();

Route::get('/', 'OnlineCatalog\Employees\EmployeesFrontendController@index');
Route::get('/employees/{id}/workers', 'OnlineCatalog\Employees\EmployeesFrontendController@workers')
    ->where('id', '[0-9]+');



Route::group(['middleware' => ['auth']], function () {
    Route::delete('employees/destroy', 'OnlineCatalog\Employees\EmployeesResourceController@destroyMany')
        ->name('employees.destroymany');
    Route::get('employees/directors/{id?}', 'OnlineCatalog\Employees\EmployeesResourceController@directors')
        ->name('employees.directors');
    Route::resource('employees', 'OnlineCatalog\Employees\EmployeesResourceController');
});

