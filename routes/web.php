<?php

use App\Invitation;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes([
    // 'register' => false
    'reset' => false
]);
Route::resource('schools', 'SchoolController');
Route::get('{school}/update-owner', 'SchoolController@updateOwner')->name('schools.update-owner');
Route::group([
    'prefix' => '/{school}',
    'middleware' => ['school', 'view-school'],
    'as' => 'school:',
], function () {
    // Auth
    Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
    // Auth | role:admin|staff
    Route::resource('users', 'UserController');
    Route::get('users/{user}/delete-confirm', 'UserController@deleteConfirm')->name('users.delete-confirm');
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
    Auth::routes([
        'register' => false,
        'reset' => false
    ]);
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
        'prefix' => 'children',
        'as' => 'children.'
    ], function () {
        Route::get('', 'ChildController@index')->name('index');
        Route::get('create', 'ChildController@create')->name('create');
        Route::post('', 'ChildController@store')->name('store');
        Route::post('half-day', 'HalfDayController@index')->name('half-day');
    });
    Route::group([
        'prefix' => '/{child}',
        'as' => 'children.',
    ], function () {
        Route::get('delete-page', 'ChildController@deletePage')->name('delete-page');
        Route::get('', 'ChildController@show')->name('show');
        Route::put('', 'ChildController@update')->name('update');
        Route::get('edit', 'ChildController@edit')->name('edit');
        Route::delete('delete', 'ChildController@destroy')->name('destroy');
        Route::get('all-checkins', 'ChildController@AllCheckins')->name('all-checkins');
        Route::get('search-checkins', 'ChildCheckinSearchController@index')->name('search-checkins');
        Route::delete('delete', 'ChildController@destroy')->name('destory');

        Route::patch('am-in', 'ChildCheckinController@amCheckin')->name('am-in');
        Route::patch('pm-in', 'ChildCheckinController@pmCheckin')->name('pm-in');
        Route::patch('pm-out', 'ChildCheckinController@pmCheckout')->name('pm-out');

        Route::get('payment', 'ChildPaymentController@showPaymentForm')->name('show-payment-form');
        Route::patch('pay-past-due', 'ChildPaymentController@payPastDue')->name('pay-past-due');
        Route::patch('pay-current-week', 'ChildPaymentController@payWeekTotal')->name('pay-current-week');

        Route::get('{checkin}', 'ChildCheckinController@show')->name('checkin');
        Route::get('{checkin}/edit', 'ChildCheckinController@edit')->name('checkin-edit');


    });
});
