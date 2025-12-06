<?php

use App\Livewire\PetManager;
use App\Models\Pet;
use App\Models\User;
use Livewire\Livewire;

it('renders the pet manager component', function () {
    Livewire::test(PetManager::class)
        ->assertStatus(200);
});

it('can create a pet', function () {
    Livewire::test(PetManager::class)
        ->set('name', 'Fluffy')
        ->set('species', 'Cat')
        ->set('breed', 'Persian')
        ->set('date_of_birth', '2020-01-01')
        ->set('weight', 4.5)
        ->call('createPet')
        ->assertHasNoErrors();

    expect(Pet::where('name', 'Fluffy')->exists())->toBeTrue();
});

it('validates pet creation', function () {
    Livewire::test(PetManager::class)
        ->set('name', '')
        ->set('species', '')
        ->set('date_of_birth', now()->addDay()->format('Y-m-d'))
        ->call('createPet')
        ->assertHasErrors(['name', 'species', 'date_of_birth']);
});

it('can search pets', function () {
    Pet::factory()->create(['name' => 'Fido']);
    Pet::factory()->create(['name' => 'Whiskers']);

    Livewire::test(PetManager::class)
        ->set('search', 'Fido')
        ->assertSee('Fido')
        ->assertDontSee('Whiskers');
});

it('can edit a pet', function () {
    $pet = Pet::factory()->create();

    Livewire::test(PetManager::class)
        ->call('editPet', $pet->id)
        ->assertSet('name', $pet->name)
        ->assertSet('editingPetId', $pet->id)
        ->set('name', 'Updated Name')
        ->call('updatePet');

    expect($pet->refresh()->name)->toBe('Updated Name');
});

it('can delete a pet', function () {
    $pet = Pet::factory()->create();

    Livewire::test(PetManager::class)
        ->call('deletePet', $pet->id);

    expect(Pet::find($pet->id))->toBeNull();
});
