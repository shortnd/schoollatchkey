<?php

namespace App\Http\Controllers\Auth;

use App\Invitation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthenticatedSchoolInvitationController extends Controller
{
    protected $school;

    public function __construct()
    {
        $this->school = app('App\School');
        $this->middleware('auth');
    }

    public function index()
    {
        return view('schools.invitation.index')->with('invitations', Invitation::where('registered_at', null)->where('school_id', $this->school->id)->orderBy('created_at', 'desc')->get());
    }
}
