<?php

namespace App\Http\Controllers;

use App\Invitation;
use Illuminate\Http\Request;

class SchoolRequestController extends Controller
{
    private $school;

    public function __construct()
    {
        $this->school = app('App\School');
    }
    public function index()
    {
        $inviations = Invitation::where('school_id', $this->school->id)->get();
    }
}
