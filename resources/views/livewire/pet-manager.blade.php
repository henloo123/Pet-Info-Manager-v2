<div>
    <h1 class="text-2xl font-bold mb-4">My Pets</h1>

    <!-- CREATE FORM -->
    <!-- wire:submit.prevent stops the standard browser reload and calls PHP -->
    <form wire:submit.prevent="createPet" class="mb-8 p-4 bg-white border rounded shadow-sm" id="create-pet-form">
        
        <div class="grid grid-cols-2 gap-4">
            
            <!-- Name Input -->
            <!-- Selenium XPath: //*[@id='pet-name'] -->
            <div>
                <label class="block text-sm font-bold mb-1" for="pet-name">Name</label>
                <input 
                    id="pet-name" 
                    wire:model="name" 
                    type="text" 
                    class="w-full border p-2 rounded"
                    placeholder="e.g. Buddy"
                >
                <!-- Error Message -->
                <!-- Selenium XPath: //*[@id='error-name'] -->
                @error('name') <span id="error-name" class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Species Select -->
            <!-- Selenium XPath: //*[@id='pet-species'] -->
            <div>
                <label class="block text-sm font-bold mb-1" for="pet-species">Species</label>
                <select id="pet-species" wire:model="species" class="w-full border p-2 rounded">
                    <option value="">Select Species</option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                    <option value="Bird">Bird</option>
                    <option value="Other">Other</option>
                </select>
                @error('species') <span id="error-species" class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Breed Input -->
            <!-- Selenium XPath: //*[@id='pet-breed'] -->
            <div>
                <label class="block text-sm font-bold mb-1" for="pet-breed">Breed</label>
                <input 
                    id="pet-breed" 
                    wire:model="breed" 
                    type="text" 
                    class="w-full border p-2 rounded"
                >
            </div>

            <!-- Date of Birth Input -->
            <!-- Selenium XPath: //*[@id='pet-dob'] -->
            <div>
                <label class="block text-sm font-bold mb-1" for="pet-dob">Birthday</label>
                <input 
                    id="pet-dob" 
                    wire:model="date_of_birth" 
                    type="date" 
                    class="w-full border p-2 rounded"
                >
            </div>

            <!-- Weight Input -->
            <!-- Selenium XPath: //*[@id='pet-weight'] -->
            <div>
                <label class="block text-sm font-bold mb-1" for="pet-weight">Weight (kg)</label>
                <input 
                    id="pet-weight" 
                    wire:model="weight" 
                    type="number" 
                    step="0.01" 
                    class="w-full border p-2 rounded"
                >
            </div>
        </div>

        <!-- Submit Button -->
        <!-- Selenium XPath: //*[@id='btn-add-pet'] -->
        <button 
            id="btn-add-pet"
            type="submit" 
            class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
            Add Pet
        </button>
    </form>

    <!-- LIST OF PETS (Keep existing code below) -->
    <div class="space-y-4" id="pet-list">
        @foreach($pets as $pet)
            <div class="p-4 border rounded bg-gray-50 flex justify-between items-center pet-item">
                <div>
                    <h3 class="font-bold text-lg">{{ $pet->name }}</h3>
                    <p class="text-gray-600">
                        {{ $pet->species }} 
                        • {{ $pet->breed ?? 'Unknown Breed' }}
                        @if($pet->date_of_birth)
                             • 🎂 {{ \Carbon\Carbon::parse($pet->date_of_birth)->format('M d, Y') }}
                        @endif
                    </p>
                </div>

                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 mr-4">
                        <!-- Shows how long ago the pet was added -->
                        {{ $pet->created_at->diffForHumans() }}
                    </span>

                    <!-- DELETE BUTTON -->
                    <!-- Selenium XPath: //*[@id='btn-delete-1'] (where 1 is the ID) -->
                    <!-- wire:click="deletePet(1)" calls the PHP function with ID 1 -->
                    <!-- wire:confirm adds a browser popup to ask "Are you sure?" -->
                    <button 
                        wire:click="deletePet({{ $pet->id }})"
                        wire:confirm="Are you sure you want to delete {{ $pet->name }}?"
                        id="btn-delete-{{ $pet->id }}"
                        class="bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 text-sm font-bold"
                    >
                        Delete
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
