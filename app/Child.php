<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Child extends Model
{
    protected $connection = 'school';

    protected $guarded = [];

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function todayCheckin()
    {
        return $this->hasOne(Checkin::class);
    }

    public function checkInToday()
    {
        // return true;
        return ($this->todayCheckin->am_in || $this->todayCheckin->pm_in);
        // return $this->todayCheckin();
        // return ($this->todayCheckin->am_in || $this->todayCheckin->pm_in);
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
}
