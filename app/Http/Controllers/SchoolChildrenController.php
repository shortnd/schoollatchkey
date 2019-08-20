<?php

namespace App\Http\Controllers;

use App\Child;
use App\ChildParent;
use App\Services\SchoolManager;
use Illuminate\Http\Request;

class SchoolChildrenController extends Controller
{

    protected $school;

    public function __construct(SchoolManager $schoolManager)
    {
        $this->school = $schoolManager->getSchool();
        $this->middleware(['auth','view-school'])->except(['index']);
    }

    public function index()
    {
        if (auth()->user()->hasRole('parent')) {
            $childParent = ChildParent::where('user_id', auth()->id())->first();
            return view('child.index')->with('children', $childParent->children);
        }
        $children = Child::all()->load('todayCheckin');
        return view('child.index')->with('children', $children);
    }

    public function create()
    {
        return view('child.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        Child::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        return redirect(route('school:school.index', $this->school));
    }

    public function show(string $slug)
    {
        try {
            $child = Child::where('slug', '=', $slug)->first();
            dd($child);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
