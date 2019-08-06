<?php

namespace App\Http\Livewire\Children;

use Livewire\Component;
use App\Child;

class CreateForm extends Component
{
    public $first_name;
    public $last_name;
    public $school;

    public function mount($school)
    {
        $this->school = $school;
    }

    public function saveChild()
    {
        $this->validate([
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3'
        ]);

        Child::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'school_id' => $this->school->id
        ]);

        $this->redirect(route('school:school.index', $this->school));
    }

    public function render()
    {
        return view('livewire.children.create-form');
    }
}
