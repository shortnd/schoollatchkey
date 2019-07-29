<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Users
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push('Users', route('users.index'));
});

Breadcrumbs::for('user', function ($trail, $user) {
    $trail->parent('users');
    $trail->push($user->name, route('users.show', $user));
});

Breadcrumbs::for('user-edit', function ($trail, $user) {
    $trail->parent('user', $user);
    $trail->push("{$user->name} Edit", route('users.edit', $user));
});

// Schools
Breadcrumbs::for('schools', function ($trail) {
    $trail->parent('home');
    $trail->push('Schools', route('schools.index'));
});
