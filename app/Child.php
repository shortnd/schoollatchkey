<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Child extends Model
{
    protected $connection = 'school';

    protected $guarded = [];

    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function todayCheckin()
    {
        return $this->checkins()->whereBetween('created_at', [today(), now()])->first();
    }

    public function checkInToday()
    {
        return ($this->todayCheckin()->am_in || $this->todayCheckin()->pm_in);
    }

    public function childParent()
    {
        return $this->belongsToMany(ChildParent::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($child) {
            $child->slug = Str::slug($child->first_name . ' ' . $child->last_name, '-');
        });

        static::created(function ($child) {
            $child->checkins()->create();
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function checkin_totals()
    {
        return $this->hasMany(CheckinTotals::class);
    }

    public function todayTotal()
    {
        $total = 0;
        $today = $this->todayCheckin();
        if ($today->am_checkin) {
            $total += 5;
        }
        if ($today->pm_checkout_time) {
            $pm_diff = Carbon::parse($today->pm_checkout_time)
                ->diff(Carbon::parse($today->pm_checkin_time))->format('%H.%I');
            $total += $pm_diff * 4;
        }
        return round($total);
    }

    public function weeklyTotal()
    {
        return $this->checkin_totals->whereBetween('created_at', [startOfWeek(), endOfWeek()]);
    }

    public function weeklyTotalAmount()
    {
        return $this->checkin_totals()->whereBetween('created_at', [startOfWeek(), endOfWeek()])->where('total_amount', '>', 0)->sum('total_amount');
    }

    public function pastDue()
    {
        return $this->checkin_totals()->where('created_at', '<', startOfWeek())->where('total_amount', '>', 0)->orderBy('id', 'desc')->get();
    }

    public function pastDueAmount()
    {
        return $this->checkin_totals()->where('created_at', '<', startOfWeek())->where('total_amount', '>', 0)->orderBy('id', 'desc')->sum('total_amount');
    }

    public function weeklyAmTotalHours()
    {
        return $this->weeklyTotal()->am_total_hours;
    }

    public function weeklyCheckinTotalHours()
    {
        return $this->weeklyTotal()->total_hours;
    }

    public function weeklyCheckins()
    {
        return $this->checkins()->whereBetween('created_at', [startOfWeek(), endOfWeek()])->first()->get();
    }

    // public function pastDue()
    // {
    //     return $this->checkin_totals()->latest()->get()->sum();
    // }

    public function addCheckin()
    {
        // return $this->todayCheckin();
        if ($this->todayCheckin()) {
            return "Already has checkin today";
        } else {
            $this->checkins()->create();
        }
    }

    public function addWeeklyTotal()
    {
        if ($this->weeklyTotal()) {
            return $errors['weeklyTotal'] = 'Weekly total already created';
        } else {
            return $this->checkin_totals()->create();
        }
    }
}
