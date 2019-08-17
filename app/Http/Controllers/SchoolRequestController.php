<?php

namespace App\Http\Controllers;

use App\Invitation;
use Illuminate\Http\Request;

class SchoolRequestController extends Controller
{
    private $school;
    public function __construct()
    {
        // TODO: Refactor this
        $this->school = app(\App\Services\SchoolManager::class);
    }
    public function index()
    {
        $inviations = Invitation::where('school_id', $this->school->getSchool()->id)->get();
        // dd($inviations);
    }
}
