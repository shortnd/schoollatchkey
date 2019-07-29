<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth', 'role:staff|admin']);
    }

    public function index()
    {
        return view('users.index')->with('users', User::with('roles')->get());
    }

    public function show(User $user)
    {
        $user = $user->load('roles');
        return view('users.show')->with('user', $user);
    }

    public function edit(User $user)
    {
        $user = $user->load('roles');
        $roles = Role::all();
        return view('users.edit')->with('user', $user)->with('roles', $roles);
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function updateRoles(Request $request, User $user)
    {
        if (!$request->has('parent')) {
            if ($user->hasRole('parent')) {
                $user->removeRole('parent');
            }
        } else {
            $user->assignRole('parent');
        }
        if (!$request->has('staff')) {
            if ($user->hasRole('staff')) {
                $user->removeRole('staff');
            }
        } else {
            $user->assignRole('staff');
        }
        if (auth()->user()->hasRole('admin')) {
            if (!$request->has('admin')) {
                if ($user->hasRole('admin')) {
                    $user->removeRole('admin');
                }
            } else {
                $user->assignRole('admin');
            }
        }
        return redirect()->back();
    }
}
