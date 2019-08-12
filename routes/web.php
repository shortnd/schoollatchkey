<?php
use Illuminate\Support\Facades\Config;
use App\School;

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
Route::resource('users', 'UserController');
Route::group(['prefix' => 'users'], function () {
    Route::patch('{user}/update-roles', 'UserController@updateRoles')->name('user.update-roles');
});
Route::group(['prefix' => '/{user}'], function () {
    Route::get('profile', 'UserProfileController@index')->name('user.profile-index');
});
Route::group([
    'prefix' => '/{school}',
    'middleware' => \App\Http\Middleware\IdentifySchool::class,
    'as' => 'school:',
], function () {
    // Route::get('/', function () {
    //     dd(request()->school);
    // })->name('school.index');
    Route::get('/', 'SchoolChildrenController@index')->name('school.index');
    Route::get('create', 'SchoolChildrenController@create')->name('children.create');
    Route::post('/', 'SchoolChildrenController@store')->name('children.store');
    Route::get('{child}', 'SchoolChildrenController@show')->name('children.show');
});
