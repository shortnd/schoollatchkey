<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChildParent extends Model
{
    protected $guarded = [];
    protected $fillable = ['id'];

    public function children()
    {
        return $this->hasMany(Child::class);
    }
}
