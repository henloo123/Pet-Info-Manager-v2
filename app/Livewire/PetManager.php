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

    //Track Editing State
    public $editingPetId = null;


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

        session() -> flash('message', 'Pet added Successfully!');
    }

    public function deletePet($id){
        // Finds the pet by ID
        $pet = Pet::find($id);

        // Checks it pet exists before deleting
        if ($pet){
            $pet -> delete();
        }
    }

    public function editPet($id){
        $pet = Pet::find($id);

        if ($pet) {
            // Enable editing mode
            $this->editingPetId = $id;
            // Populate form fields with existing pet data
            $this->name = $pet->name;
            $this->species = $pet->species;
            $this->breed = $pet->breed;
            $this->weight = $pet->weight;
            $this->date_of_birth = $pet -> date_of_birth ? $pet -> date_of_birth -> format('Y-m-d') : '';
        }
    }

    public function cancelEdit(){
        $this -> reset(['editingPetId', 'name', 'species', 'breed', 'weight', 'date_of_birth']);
    }

    public function updatePet(){
        $this -> validate();

        // Find the pet being edited
        if($this -> editingPetId){
            $pet = Pet::find($this -> editingPetId);

            if ($pet){
                $pet -> update([
                    'name' => $this -> name,
                    'species' => $this -> species,
                    'breed' => $this -> breed,
                    'weight' => $this -> weight ?: null,
                    'date_of_birth' => $this -> date_of_birth ?: null,
                ]);
            }
        }
        // Cancel editing mode and reset form
        $this -> cancelEdit();
        
    }

    public function render()
    {
        return view('livewire.pet-manager', ['pets' => Pet::latest()->get()])->layout('components.layouts.simple');
    }
}
