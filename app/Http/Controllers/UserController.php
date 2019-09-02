<?php

namespace App\Http\Controllers;

use App\ChildParent;
use App\Jobs\ChildParentCreateJob;
use App\Jobs\ChildParentDeleteJob;
use App\Services\SchoolManager;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private $schoolManager;

    public function __construct(SchoolManager $schoolManager)
    {
        $this->schoolManager = $schoolManager;
        return $this->middleware(['auth', 'role:staff|admin']);
    }

    public function index()
    {
        return view('users.index')->with('users', User::where('id','!=', auth()->id())->where('school_id', $this->schoolManager->getSchool()->id)->with('roles')->get());
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

    public function deleteConfirm(User $user)
    {
        return view('users.delete-confirm')->with('user', $user);
    }

    public function destroy(User $user)
    {
        $school = $this->schoolManager->getSchool();
        if ($user->hasRole('parent')) {
            try {
                $childParent = ChildParent::where('user_id', $user->id)->first();
            } catch (\Exception $e) {
                // TODO: All Log or something here
            }
            if ($childParent != null) {
                $childParent->delete();
            }
            $user->delete();
        }

        if ($user->hasRole('staff')) {
            $user->delete();
        }

        if ($user->hasRole('admin')) {
            if ($user->id == $school->owner_id) {
                return redirect()->back()->withErrors('owner', 'The requested user is the owner of the school');
            }
            $user->delete();
        }
        return redirect(route('school:school.index', $this->schoolManager->getSchool()))->with('school', 'User deleted');
    }
}
