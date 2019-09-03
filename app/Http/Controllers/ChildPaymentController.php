<?php

namespace App\Http\Controllers;

use App\Child;
use Illuminate\Http\Request;

class ChildPaymentController extends Controller
{
    public function showPaymentForm(Request $request, Child $child)
    {
        $child->current_week_total = $child->weeklyTotalAmount();
        $child->past_due = $child->pastDueAmount();

        return view('schools.payment.show')->with(['child' => $child]);
    }

    public function payPastDue(Request $request, Child $child)
    {
        $this->validate($request, [
            'past_due_amount' => 'required'
        ]);
        $paymentAmount = $request->past_due_amount;
        if ($request->has('payment_credit')) {
            $paymentAmount = $paymentAmount + $child->payment_credit;
            $child->update(['payment_credit' => 0]);
        }
        $paymentOverdue = $child->pastDue();

        foreach ($paymentOverdue as $payment) {
            if ($payment->total_amount >= $paymentAmount) {
                $paymentTotalAmount = $payment->total_amount;
                $payment->update([
                    'total_amount' => $paymentTotalAmount - $paymentAmount
                ]);
                $paymentAmount = $paymentTotalAmount - $paymentAmount;
                return redirect()->back();
            }
            $paymentAmount = $paymentAmount - $payment->total_amount;
            $payment->update([
                'total_amount' => 0
            ]);
        }
        if ($paymentAmount > 0) {
            $child->update([
                'payment_credit' => $paymentAmount
            ]);
        }
        // TODO: Try to implement child->payment_credit
        $errors['past_due_amount'] = "Payment amount is more then you owe";
        return redirect()->back()->withErrors($errors);
    }

    public function payWeekTotal(Request $request, Child $child)
    {
        $this->validate($request, [
            'total_amount' => 'required'
        ]);
        $paymentAmount = $request->total_amount;
        if ($request->has('payment_credit')) {
            $paymentAmount = $paymentAmount + $child->payment_credit;
        }
        $weeklyDue = $child->checkin_totals()->whereBetween('created_at', [startOfWeek(), endOfWeek()])->first();
        $weeklyDueTotal = $weeklyDue->total_amount;
        while($paymentAmount <= $weeklyDueTotal) {
            $difference = $weeklyDueTotal - $paymentAmount;
            $weeklyDue->update([
                'total_amount' => $weeklyDueTotal - $paymentAmount
            ]);
            $child->update([
                'payment_credit' => $difference
            ]);
            return redirect()->back();
        }
        $child->update([
            'payment_credit' => $paymentAmount
        ]);
        return redirect()->back();
    }
}
