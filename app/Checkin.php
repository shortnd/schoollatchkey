<?php

namespace App;

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
}
