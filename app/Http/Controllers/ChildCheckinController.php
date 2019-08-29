<?php

namespace App\Http\Controllers;

use App\Checkin;
use App\Child;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChildCheckinController extends Controller
{
    public function amCheckin(Request $request, Child $child)
    {
        $this->validate($request, [
            'am_checkin' => 'required',
        ]);

        $checkin = $child->todayCheckin();
        $checkinTotals = $child->weeklyTotal();

        $checkin->update([
            'am_checkin' => $request->has(['am_checkin']),
            'am_checkin_time' => now()
        ]);

        $endTime = Carbon::create(
            today()->format('Y'),
            today()->format('m'),
            today()->format('d'),
            8,
            15,
            0
        );

        $todayAmTotalHours = $checkin->am_checkin_time->diff($endTime)->format('%H.%I');

        $checkinTotals->update([
            'total_hours' => $todayAmTotalHours,
            'am_total_hours' => $todayAmTotalHours,
            'total_amount' => 5
        ]);

        return back();
    }

    public function pmCheckin(Request $request, Child $child)
    {
        $this->validate($request, [
            'pm_checkin' => 'required'
        ]);

        $pm_checkin = $child->todayCheckin();

        $time = Carbon::create(
            today()->format('Y'),
            today()->format('m'),
            today()->format('d'),
            15,
            0,
            0
        );

        $pm_checkin->update([
            'pm_checkin' => $request->has('pm_checkin'),
            'pm_checkin_time' => $time,
        ]);

        return back();
    }

    public function pmCheckout(Request $request, Child $child)
    {
        $this->validate($request, [
            // 'sig' => 'required|min:10000',
            'pm_checkout' => 'required'
        ]);

        $pm_checkout = $child->todayCheckin();
        $checkinTotals = $child->weeklyTotal();

        if ($request->has('pm_checkout')) {
            // TODO: Implement upload to cloudiary
            $pm_checkout->update([
                'pm_checkout_time' => now(),
                // 'pm_sig' => $request->sig
            ]);

            $pm_diff = Carbon::parse(
                $pm_checkout->pm_checkin_time
            )->diff(
                $pm_checkout->pm_checkout_time
            )->format('%H.%I');
            $rollingTotalHours = round($checkinTotals->total_amount + $pm_diff);

            $pm_amount = $pm_diff * 4;
            $rollingTotalAmount = round($checkinTotals->total_amount + $pm_amount);

            $checkinTotals->update([
                'total_hours' => $rollingTotalHours,
                'total_amount' => $rollingTotalAmount
            ]);
        } else {
            return $errors['pm_checkout'] = 'Invalid Input';
        }
        return back();
    }

    public function show(Child $child, Checkin $checkin)
    {
        return view('child.checkins.show')->with(['child' => $child, 'checkin' => $checkin]);
    }
}
