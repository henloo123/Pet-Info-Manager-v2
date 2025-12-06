<?php

namespace App\Livewire;

use App\Models\Pet;
use Livewire\Component;

class PetManager extends Component
{
    //Form Properties
    public $name = '';
    public $species = '';
    public $breed = '';
    public $date_of_birth = '';
    public $weight = '';

    protected $rules = [
        'name' => 'required|min:2',
        'species' => 'required',
        'breed' => 'nullable|string',
        'weight' => 'nullable|numeric',
        'date_of_birth' => 'nullable|date',
    ];

    public function createPet(){
        $this -> validate();

        Pet::create([
            'name' => $this -> name,
            'species' => $this -> species,
            'breed' => $this -> breed,
            'weight' => $this -> weight,
            'date_of_birth' => $this -> date_of_birth,
        ]);

        $this -> reset(['name', 'species', 'breed', 'weight', 'date_of_birth']);
    }

    public function render()
    {
        return view('livewire.pet-manager', ['pets' => Pet::latest()->get()])->layout('components.layouts.simple');
    }
}
