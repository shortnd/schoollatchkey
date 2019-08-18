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
        return $this->hasMany(Child::class);
    }
}
