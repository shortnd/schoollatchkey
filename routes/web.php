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
    ], function () {
        Route::get('/', 'ChildController@show')->name('show');
        Route::get('all-checkins', 'ChildController@AllCheckins')->name('all-checkins');
        Route::delete('delete', 'ChildController@destroy')->name('destory');

        Route::patch('am-in', 'ChildCheckinController@amCheckin')->name('am-in');
        Route::patch('pm-in', 'ChildCheckinController@pmCheckin')->name('pm-in');
        Route::patch('pm-out', 'ChildCheckinController@pmCheckout')->name('pm-out');

        Route::get('{checkin}', 'ChildCheckinController@show');

        Route::get('payment', 'ChildPaymentController@showPaymentForm')->name('show-payment-form');
        Route::patch('pay-past-due', 'ChildPaymentController@payPastDue')->name('pay-past-due');
        Route::patch('pay-current-week', 'ChildPaymentController@payWeekTotal')->name('pay-current-week');

    });

    /**
     *  Route::get('children/weekly-totals', 'ChildController@weekly_totals')->name('weekly_totals');
    Route::resource('children', 'ChildController');
    Route::patch('children/{child}/update-contract', 'ChildController@updateContact')->name('update-contact');
    Route::post('add-day/{child}', 'ChildCheckinController@addNewCheckins')->name('add_child');

    // Search for past checkins
    Route::get('{child}/search-form', 'ChildSearchController@index')->name('search-form');
    Route::get('{child}/search-form/results', 'ChildSearchController@show')->name('search-results');
    // Payments
    Route::get('{child}/payment', 'ChildPaymentController@showPaymentForm')->name('show-payment-form');
    Route::patch('{child}/pay-past-due', 'ChildPaymentController@payPastDue')->name('pay-past-due');
    Route::patch('{child}/pay-current-week', 'ChildPaymentController@payWeekTotal')->name('pay-current-week');

     */
});
