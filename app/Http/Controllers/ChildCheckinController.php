<?php

namespace App\Http\Controllers;

use App\Child;
use Illuminate\Http\Request;

class ChildCheckinController extends Controller
{
    public function amCheckin(Request $request, Child $child)
    {
        if ($request->has('am_in')) {
            $child->todayCheckin->update(['am_in' => now()]);
        } else {
            $child->update(['am_in' => null]);
        }

        return back();
    }

    public function pmCheckin(Request $request, Child $child)
    {
        if ($request->has('pm_in')) {
            $child->todayCheckin->update(['pm_in' => now()]);
        } else {
            $child->todayCheckin->update(['pm_in' => null]);
        }

        return back();
    }

    public function pmCheckout(Request $request, Child $child)
    {
        if ($request->has('pm_out')) {
            $child->todayCheckin->update(['pm_out' => now()]);
        }

        return back();
    }
}
