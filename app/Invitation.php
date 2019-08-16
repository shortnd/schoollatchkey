<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'email', 'invitation_token', 'registered_at', 'school_id'
    ];

    public function generateInvitationToken()
    {
        $this->invitation_token = substr(md5(rand(0, 9) . $this->email . time()), 0, 32);
    }

    public function getLink()
    {
        return urldecode(route('school:show-registration', app(\App\Services\SchoolManager::class)->getSchool()) . '?invitation_token=' . $this->invitation_token);
    }
}
