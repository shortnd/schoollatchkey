<?php

namespace App;

use App\Jobs\SchoolDatabase;
use App\Services\SchoolManager;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class School extends Model
{
    protected $fillable = ['name', 'state'];

    protected $guarded = ['slug', 'school_id'];

    // public function children()
    // {
    //     return $this->hasMany(Child::class);
    // }

    // public function addChild($request)
    // {
    //     $this->children()->create($request);
    // }


    // public function checkins()
    // {
    //     return $this->hasManyThrough(
    //         Checkin::class,
    //         Child::class,
    //         'school_id',
    //         'child_id',
    //         'id',
    //         'id'
    //     );
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($school) {
            $school->slug = Str::lower($school->name);
            $school->owner_id = auth()->id();
        });

        static::created(function ($school) {
            SchoolDatabase::dispatch($school, app('App\Services\SchoolManager'));
        });
    }

    public function route($name, $parameters = [], $absolute = true) {
        return app('url')->route($name, array_merge([$this->slug], $parameters), $absolute);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function owner()
    {
        $this->hasOne(User::class);
    }

    public function users()
    {
        $this->hasMany(User::class);
    }
}
