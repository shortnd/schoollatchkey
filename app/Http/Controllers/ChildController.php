<?php

namespace App\Http\Controllers;

use App\Child;
use App\Services\SchoolManager;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ChildController extends Controller
{
    private $school;
    public function __construct(SchoolManager $schoolManager)
    {
        $this->school = $schoolManager->getSchool();
        $this->middleware(['auth']);
        $this->middleware(['role:admin|staff'], ['except' => [
            'index',
            'show'
        ]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('schools.children.index')->with('children', Child::get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('child.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255'
        ]);

        Child::create($validatedData);

        return redirect(route('school:school.index', app('App\School')));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function show(Child $child)
    {
        $parents = $child->childParent;
        $todayCheckin = $child->todayCheckin();

        return view('schools.children.show')->with(['child' => $child, 'today_checkin' => $todayCheckin]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function edit(Child $child)
    {
        return view('schools.children.edit')->with('child', $child);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Child $child)
    {
        //
    }

    public function deletePage(Child $child)
    {
        return view('schools.children.delete-page')->with('child', $child);
    }

    public function destroy(Child $child)
    {
        $child->delete();

        return redirect(route('school:school.index'));
    }

    // public function updateContact(Request $request, Child $child)
    // {
    //     //
    // }

    public function AllCheckins(Child $child)
    {
        return view('school.children.all-checkins')->with('child', $child->with('checkins'));
    }


}
