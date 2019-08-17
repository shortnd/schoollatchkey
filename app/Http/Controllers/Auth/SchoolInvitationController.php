<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\SchoolInvitationRequest;
use App\Http\Controllers\Controller;
use App\Invitation;
use App\School;
use App\Services\SchoolManager;
use Illuminate\Http\Request;

class SchoolInvitationController extends Controller
{
    protected $school;
    protected $schoolManager;

    public function __construct()
    {
        $this->school = app('App\Services\SchoolManager');
        $this->middleware('guest');
    }

    public function store(Request $request)
    {
        $school = $this->school->getSchool();

        $this->validate($request, [
            'email' => 'required|email|unique:invitations'
        ]);

        $invitaion = new Invitation($request->only('email'));
        $invitaion->generateInvitationToken();
        $invitaion->school_id = $school->id;
        $invitaion->save();

        return redirect()->route('school:request-invitation', $school)->with('success', 'Invitation to register succesfully requested. Please wait for the registration link to be emailed to you.');
    }

    public function showRegistrationForm(Request $request)
    {
        $invitaion_token = $request->get('invitation_token');
        $invitation = Invitation::where('invitation_token', $invitaion_token)->firstOrFail();
        // try {
        //     $school = School::where(''$invitation->school_id)->first();
        // } catch (\Exception $e) {
        //     return $e;
        // }
        $email = $invitation->email;

        return view('schools.auth.register')->with(['email' => $email,
        // 'school' => $school
        ]);
    }
}
