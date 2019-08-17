<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolRegisteredController extends Controller
{
    public function success()
    {
        return view('schools.auth.register-success');
    }
}
