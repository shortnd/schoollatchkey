<?php

namespace App\Http\Controllers;

use App\Child;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChildCheckinSearchController extends Controller
{
    public function index(Request $request, Child $child)
    {
        $checkins = null;
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->start_date)->subDay();
            $end_date = Carbon::parse($request->end_date)->addDay();
            $checkins = $child->checkins()->whereBetween('created_at', [
                $start_date,
                $end_date
            ])->get();
        }
        return view('schools.child.search.index')->with(['child' => $child, 'checkins' => $checkins]);
    }
}
