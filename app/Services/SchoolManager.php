<?php
namespace App\Services;

use App\School;

class SchoolManager {
    private $school;

    public function setSchool(?School $school)
    {
        $this->school = $school;
        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function loadSchool(string $identifier): bool
    {
        $school = School::query()->where('slug', '=', $identifier)->first();

        if ($school) {
            $this->setSchool($school);
            return true;
        }

        return false;
    }
}
