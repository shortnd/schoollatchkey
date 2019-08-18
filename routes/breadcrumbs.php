<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    // $trail->push('Home', route('home'));
    $trail->push('Home', route('school:school.index', app('App\School')));
});

// Users
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push('Users', route('school:users.index', app('App\School')));
});

Breadcrumbs::for('user', function ($trail, $user) {
    $trail->parent('users');
    $trail->push($user->name, route('school:users.show', [app('App\School'), $user]));
});

Breadcrumbs::for('user-edit', function ($trail, $user) {
    $trail->parent('user', $user);
    $trail->push("{$user->name} Edit", route('school:users.edit', [app('App\School'), $user]));
});

// Schools
Breadcrumbs::for('schools', function ($trail) {
    $trail->parent('home');
    $trail->push('Schools', route('schools.index'));
});
