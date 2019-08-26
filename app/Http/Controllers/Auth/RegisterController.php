<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Invitation;
use Illuminate\Http\Request;
use App\Jobs\ChildParentCreateJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    /**
     * , School $school
     */
    protected function create(array $data)
    {
        if (! app('App\Services\SchoolManager')->getSchool()) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);

            $user->assignRole('admin');

            return $user;
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'school_id' => app('App\School')->id,
        ]);

        $user->assignRole('parent');
        ChildParentCreateJob::dispatchNow($user);

        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if (! app('App\Services\SchoolManager')->getSchool()) {
            event(new Registered($this->create($request->all())));

            return redirect(route('login'));
        }
        try {
            $invitation = Invitation::where('invitation_token', $request->invitation_token)->where('registered_at', null)->first();
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withError(['token' => 'That token is now invalid']);
        }

        $invitation->update(['registered_at' => now()]);

        event(new Registered($this->create($request->all())));

        return redirect(route('school:auth-success', app('App\School')));
    }
}
