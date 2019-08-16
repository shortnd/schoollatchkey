<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\SchoolInvitationRequest;
use App\Http\Controllers\Controller;
use App\Invitation;
use App\School;
use Illuminate\Http\Request;

class SchoolInvitationController extends Controller
{
    public function index()
    {
        return view('schools.invitations.index')->with('invitations', Invitation::where('registered_at', null)->orderBy('created_at', 'desc')->get());
    }

    public function store(SchoolInvitationRequest $schoolInvitationRequest, Request $request)
    {
        $invitaion = new Invitation($schoolInvitationRequest->all());
        $invitaion->generateInvitationToken();
        $invitaion->school_id = $request->school->id;
        $invitaion->save();

        return redirect()->route('requestInvitation')->with('success', 'Invitation to register succesfully requested. Please wait for the registration link to be emailed to you.');
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
