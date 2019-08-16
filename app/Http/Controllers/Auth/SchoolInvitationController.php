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

    public function __construct()
    {
        $this->school = app(\App\Services\SchoolManager::class);
    }

    public function index()
    {
        return view('schools.invitation.index')->with('invitations', Invitation::where('registered_at', null)->orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:invitations'
        ]);

        $invitaion = new Invitation($request->only('email'));
        $invitaion->generateInvitationToken();
        $invitaion->school_id = $this->school->getSchool()->id;
        $invitaion->save();

        return redirect()->route('school:request-invitation')->with('success', 'Invitation to register succesfully requested. Please wait for the registration link to be emailed to you.');
    }

    public function showRegistrationForm(Request $request)
    {
        $invitaion_token = $request->get('invitation_token');
        $invitation = Invitation::where('invitation_token', $invitaion_token)->firstOrFail();
        try {
            $school = School::where('id', $invitaion_token->school_id)->first();
        } catch (\Exception $e) {
            return $e;
        }
        $email = $invitation->email;

        return view('school.auth.register')->with(['email' => $email, 'school' => $school]);
    }
}
