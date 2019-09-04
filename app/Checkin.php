<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $connection = 'school';

    protected $dates = [
        'am_in',
        'pm_in',
        'pm_out',
        'created_at',
        'updated_at'
    ];

    protected $guarded = [];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function today($child)
    {
        // TODO: Do you need to do this?
    }

    public function am_disabled()
    {
        $time = Carbon::now()->format('H.m');
        if ($time > 6.15 && $time < 7.45) {
            return false;
        }
        return true;
    }

    public function pm_disabled()
    {
        $time = Carbon::now()->format('H.m');
        if ($time > 15.3 && $time < 17.3) {
            return false;
        }
        return true;
    }

    public function amCheckinTime()
    {
        return Carbon::parse($this->am_checkin_time)->format('h:i a');
    }

    public function pmCheckinTime()
    {
        return Carbon::parse($this->pm_checkin_time)->format('h:i a');
    }

    public function pmCheckoutTime()
    {
        return Carbon::parse($this->pm_checkout_time)->format('h:i a');
    }

    public function getCheckoutDiffHumans()
    {
        return Carbon::parse($this->pm_checkout_time)->diffForHumans();
    }
}
