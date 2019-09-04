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
        $this->school = $schoolManager;
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
            'last_name' => 'required|min:2|max:255',
            'room_number' => 'required|min:3|max:3'
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
        $weekCheckin = $child->checkins->whereBetween('created_at', [startOfWeek(), endOfWeek()])->take(5);
        $pastWeekCheckin = $child->checkins->whereBetween('created_at', [startOfWeek()->subWeek(), endOfWeek()->subWeek()])->take(5);
        $currentWeekTotal = $child->weeklyTotalAmount();
        $pastDueAmount = $child->checkin_totals->where('created_at', startOfWeek()->subWeek())->where('total_amount')->pluck('total_amount')->sum();

        return view('schools.children.show')->with([
            'child' => $child,
            'today_checkin' => $todayCheckin,
            'week_checkin' => $weekCheckin,
            'past_week' => $pastWeekCheckin,
            'current_week_total' => $currentWeekTotal,
            'past_due' => $pastDueAmount
        ]);
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
        $validatedData = $this->validate($request, [
            'first_name' => 'required|min:3|string',
            'last_name' => 'required|min:3|string',
            'room_number' => 'required|min:100|max:999|numeric',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone_number' => 'nullable|string|required_if:emergency_contact_name,string',
            'emergency_contact_relationship' => 'nullable|string|required_if:emergency_contact_name,string'
        ]);
        $child->update($validatedData);
        return redirect()->route('school:children.show', [$this->school->getSchool(), $child]);
        // dd($validatedData);
        //
    }

    public function deletePage(Child $child)
    {
        return view('schools.children.delete-page')->with('child', $child);
    }

    public function destroy(Child $child)
    {
        $child->delete();

        return redirect(route('school:school.index', $this->school->getSchool()));
    }

    // public function updateContact(Request $request, Child $child)
    // {
    //     //
    // }

    public function AllCheckins(Child $child)
    {
        $child->months = $child->checkins->groupBy(function ($month) {
            return Carbon::parse($month->created_at)->format('m');
        });

        return view('school.children.all-checkins')->with('checkins', $child);
    }


}
