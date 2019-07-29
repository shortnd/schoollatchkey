<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $guarded = [];

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function parents()
    {
        // return $this->belongsToMany(ChildParent::class);
        return $this->belongsToMany(User::class);
    }
}
