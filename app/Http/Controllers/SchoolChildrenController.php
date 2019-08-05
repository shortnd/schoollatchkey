<?php

namespace App\Http\Controllers;

use App\Child;
use App\School;
use Illuminate\Http\Request;

class SchoolChildrenController extends Controller
{

    public function index(School $school)
    {
        return view('child.index')->with('children', $school->children);
    }

    public function create()
    {
        return view('child.create');
    }

    public function store(Request $request, School $school)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        Child::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'school_id' => $school->id
        ]);

        return redirect(route('school:school.index', $school));
    }

    public function show(School $school, Child $child)
    {
        dd($child);
    }
}
