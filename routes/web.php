<?php

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['register' => false]);
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
    'middleware' => 'school',
    'as' => 'school:',
], function () {
    Route::get('/', 'SchoolChildrenController@index')->name('school.index');
    // Route::resource('children', 'ChildController');
    Route::get('add-child', 'ChildController@create')->name('children.create');
    Route::post('add-child', 'ChildController@store')->name('children.store');
    Route::group([
        'prefix' => '/{child}',
        'as' => 'children.'
    ], function () {
        Route::get('/', 'ChildController@show')->name('show');
        Route::delete('delete', 'ChildController@destroy')->name('destory');
        Route::patch('am-in', 'ChildCheckinController@amCheckin')->name('am-in');
        Route::patch('pm-in', 'ChildCheckinController@pmCheckin')->name('pm-in');
        Route::patch('pm-out', 'ChildCheckinController@pmCheckout')->name('pm-out');
    });
});
