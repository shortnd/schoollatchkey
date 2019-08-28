<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckinTotals extends Model
{
    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
