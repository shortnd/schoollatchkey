<?php

use App\Invitation;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes([
    'register' => false
]);
Route::resource('schools', 'SchoolController');
Route::group([
    'prefix' => '/{school}',
    'middleware' => 'school',
    'as' => 'school:',
], function () {
    // Auth
    Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
    // Auth | role:admin|staff
    Route::resource('users', 'UserController');
    // Auth | role:admin|staff
    Route::group(['prefix' => 'users'], function () {
        Route::patch('{user}/update-roles', 'UserController@updateRoles')->name('user.update-roles');
    });
    // Auth
    Route::group(['prefix' => '/{user}'], function () {
        Route::get('profile', 'UserProfileController@index')->name('user.profile-index');
    });
    // Auth
    Route::get('/', 'SchoolChildrenController@index')->name('school.index');
    // Route::resource('children', 'ChildController');
    // Auth | role:admin|staff
    Route::get('add-child', 'ChildController@create')->name('children.create');
    Route::post('add-child', 'ChildController@store')->name('children.store');
    // Register Request Route
    // Guest
    Route::get('register/request', 'Auth\SchoolRegisterController@requestInvitation')->name('request-invitation');
    // Auth | role:admin|staff
    Route::get('invitations', 'Auth\AuthenticatedSchoolInvitationController@index')->name('show-invitations');
    Route::post('invitations', 'Auth\SchoolInvitationController@store')->name('store-invitation');
    Route::delete('invitations/{invitation}/delete', 'Auth\SchoolInvitationController@delete')->name('delete-invitation');
    // Guest
    Route::get('register', 'Auth\SchoolInvitationController@showRegistrationForm')->name('show-registration')->middleware('hasInvitation');
    Route::post('register', 'Auth\RegisterController@register')->name('register');
    Route::get('success', 'Auth\SchoolRegisteredController@success')->name('auth-success');
    Auth::routes(['register' => false]);
    // Auth | role:admin|staff
    Route::group([
        'prefix' => '/parents',
        'as' => 'parents.',
        'middleware' => 'role:admin|staff, auth'
    ], function () {
        Route::get('/', 'ChildParentController@index')->name('index');
        Route::get('{user}', 'ChildParentController@show')->name('show');
        Route::post('{user}/{child}/attach', 'ParentChildConnectionController@attach')->name('child-attach');
        Route::post('{user}/{child}/detach', 'ParentChildConnectionController@detach')->name('child-detach');
    });
    Route::group([
        'prefix' => '/{child}',
        'as' => 'children.',
        // 'middleware' => 'auth'
    ], function () {
        Route::get('/', 'ChildController@show')->name('show');
        Route::delete('delete', 'ChildController@destroy')->name('destory');
        Route::patch('am-in', 'ChildCheckinController@amCheckin')->name('am-in');
        Route::patch('pm-in', 'ChildCheckinController@pmCheckin')->name('pm-in');
        Route::patch('pm-out', 'ChildCheckinController@pmCheckout')->name('pm-out');
    });
});
