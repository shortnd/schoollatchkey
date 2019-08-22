<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin|staff', 'auth']);
    }
    public function index()
    {
        // TODO: Wire this up
    }
}
