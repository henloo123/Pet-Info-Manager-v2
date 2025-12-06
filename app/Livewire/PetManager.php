<?php

namespace App\Livewire;

use Livewire\Component;

class PetManager extends Component
{
    public function render()
    {
        return view('livewire.pet-manager')->layout('components.layouts.simple');
    }
}
