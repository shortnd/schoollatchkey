<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;
use App\School;

class SchoolViewModel extends ViewModel
{
    public function __construct(School $school = null)
    {
        $this->school = $school;
    }

    public function school(): School
    {
        return $this->school ?? new School();
    }
}
