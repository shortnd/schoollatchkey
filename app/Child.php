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

    // public function school()
    // {
    //     // return $this->belongsTo(School::class);
    // }

    // public function parents()
    // {
    //     return $this->belongsToMany(User::class);
    // }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($child) {
            $child->slug = Str::slug($child->first_name . ' ' . $child->last_name, '-');
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
