<?php

namespace App\Http\Controllers;

use App\Child;
use Illuminate\Http\Request;

class HalfDayController extends Controller
{
    public function index(Request $request)
    {
        $children = Child::get();

        foreach ($children as $child) {
            $child->update([
                'half_day' => $child->half_day ? false : true
            ]);
        }

        return redirect()->back();
    }
}
