<?php
use Illuminate\Support\Facades\Config;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('schools', 'SchoolController');
// Route::group(['middleware' => ['auth','role:staff|admin']], function() {
Route::resource('users', 'UserController');
Route::group(['prefix' => 'users'], function () {
    Route::patch('{user}/update-roles', 'UserController@updateRoles')->name('user.update-roles');
});
    // Route::patch('')
// });

Route::group(["domain" => "{school}.".Config::get('app.url'), ['middleware' => ['role:parent|staff|admin']]], function() {
    Route::get('', function() {
        return dd('Working');
    })->name('school.index');
});
