<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChildParent extends Model
{
    protected $connection = 'school';

    protected $guarded = ['id'];

    protected $fillable = ['user_id'];

    public function children()
    {
        return $this->belongsToMany(Child::class);
    }

    public function getRouteKeyName()
    {
        return 'user_id';
    }
}
