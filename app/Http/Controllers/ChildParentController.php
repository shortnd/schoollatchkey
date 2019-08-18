<?php

namespace App\Http\Controllers;

use App\User;
use App\Child;
use App\ChildParent;
use Illuminate\Http\Request;

class ChildParentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin|staff', 'auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = User::whereHas("roles", function ($query) {
            $query->where("name", "parent");
        })->get();

        return view('parents.index')->with('parents', $parents);
    }

    public function show(User $user)
    {
        if (!$user->hasRole("parent")) {
            abort(404);
        }
        $children = Child::all();
        return view('parents.show')->with('parent', $user)->with('children', $children);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\ChildParent  $childParent
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(ChildParent $childParent)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\ChildParent  $childParent
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(ChildParent $childParent)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\ChildParent  $childParent
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, ChildParent $childParent)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\ChildParent  $childParent
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(ChildParent $childParent)
    // {
    //     //
    // }
}
