<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SchoolManager;

class SchoolRegisterController extends Controller
{
    protected $school;

    public function __construct(SchoolManager $schoolManager)
    {
        $this->school = app('App\School');
    }

    public function requestInvitation()
    {
        return view('auth.request')->with('school', $this->school);
    }
}
