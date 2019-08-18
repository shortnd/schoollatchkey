<?php

namespace App\Http\Controllers;

use App\Jobs\ChildParentCreateJob;
use App\Jobs\ChildParentDeleteJob;
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
        return view('users.index')->with('users', User::where('id','!=',auth()->id())->with('roles')->get());
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

    private function updateRole($request, $user, string $roleName)
    {
        if (!$request->has($roleName)) {
            if ($user->hasRole($roleName)) {
                if ($roleName == 'parent') {
                    ChildParentDeleteJob::dispatchNow($user);
                }
                $user->removeRole($roleName);
            }
        }
        if ($request->has($roleName)) {
            if ($user->hasRole($roleName)) {
                return;
            }
            $user->assignRole($roleName);
            if ($roleName == 'parent') {
                ChildParentCreateJob::dispatchNow($user);
            }
        }
    }

    public function updateRoles(Request $request, User $user)
    {
        $this->updateRole($request, $user, 'parent');
        $this->updateRole($request, $user, 'staff');
        $this->updateRole($request, $user, 'admin');
        return redirect()->back();
    }
}
