<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class School extends Model
{
    protected $fillable = ['name', 'state'];

    protected $guarded = ['slug', 'school_id'];

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function addChild($request)
    {
        $this->children()->create($request);
    }


    public function checkins()
    {
        return $this->hasManyThrough(
            Checkin::class,
            Child::class,
            'school_id',
            'child_id',
            'id',
            'id'
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($school) {
            $school->slug = Str::lower($school->name);
            $school->owner_id = auth()->id();
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}