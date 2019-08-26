<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'school_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'school_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function children()
    {
        $childParent = ChildParent::where('user_id', auth()->id())->first();
        return $childParent;
    }

    // public function children()
    // {
    //     if (!$this->hasRole('parent')) {
    //         return;
    //     }
    //     return $this->belongsToMany(Child::class);
    // }

    // public function school()
    // {
    //     if ($this->hasRole('staff|parent')) {
    //         return $this->hasMany(School::class);
    //     }
    //     return;
    // }
}
