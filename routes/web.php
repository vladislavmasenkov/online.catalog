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
    Route::get('employees/{id}/directors', 'OnlineCatalog\Employees\EmployeesResourceController@getDirectors')
        ->name('employees.directors');
    Route::put('employees/{id}/director', 'OnlineCatalog\Employees\EmployeesResourceController@updateDirector')
        ->name('employees.director');
    Route::resource('employees', 'OnlineCatalog\Employees\EmployeesResourceController');
});

