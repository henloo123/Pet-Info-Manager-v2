<div>
    
     
    <h1 @class(['text-2xl', 'font-bold', 'mb-4'])>My Pets</h1>

        <!-- FLASH MESSAGE -->
    @if (session()->has('message'))
        <div 
            id="flash-message"
            class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-900 dark:border-green-600 dark:text-green-100 px-4 py-3 rounded relative mb-4" 
            role="alert"
        >
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- CREATE FORM -->
    <!-- wire:submit.prevent stops the standard browser reload and calls PHP -->

    <!-- Header that changes based on mode -->
    <h2 class = "text-lg font-bold mb-4 border-b pb-2">{{ $editingPetId ? 'Edit Pet' : 'Add New Pet' }}</h2>

    <!-- Form that runs different functions based on mode -->
    <form wire:submit.prevent="{{ $editingPetId ? 'updatePet' : 'createPet' }}" @class(['mb-8', 'p-4', 'bg-white', 'border', 'rounded', 'shadow-sm', 'dark:bg-gray-700', 'dark:border-gray-600']) id="create-pet-form">
        
        <div @class(['grid', 'grid-cols-2', 'gap-4'])>
            
            <!-- Name Input -->
            <!-- Selenium XPath: //*[@id='pet-name'] -->
            <div>
                <label @class(['block', 'text-sm', 'font-bold', 'mb-1', 'dark:text-gray-300']) for="pet-name">Name</label>
                <input 
                    id="pet-name" 
                    wire:model="name" 
                    type="text" 
                    @class(['w-full', 'border', 'p-2', 'rounded', 'dark:bg-gray-800', 'dark:border-gray-600', 'dark:text-white'])
                    placeholder="e.g. Buddy"
                >
                <!-- Error Message -->
                <!-- Selenium XPath: //*[@id='error-name'] -->
                @error('name') <span id="error-name" @class(['text-red-500', 'text-xs'])>{{ $message }}</span> @enderror
            </div>

            <!-- Species Select -->
            <!-- Selenium XPath: //*[@id='pet-species'] -->
            <div>
                <label @class(['block', 'text-sm', 'font-bold', 'mb-1', 'dark:text-gray-300']) for="pet-species">Species</label>
                <select id="pet-species" wire:model="species" @class(['w-full', 'border', 'p-2', 'rounded', 'dark:bg-gray-800', 'dark:border-gray-600', 'dark:text-white'])>
                    <option value="">Select Species</option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                    <option value="Bird">Bird</option>
                    <option value="Other">Other</option>
                </select>
                @error('species') <span id="error-species" @class(['text-red-500', 'text-xs'])>{{ $message }}</span> @enderror
            </div>

            <!-- Breed Input -->
            <!-- Selenium XPath: //*[@id='pet-breed'] -->
            <div>
                <label @class(['block', 'text-sm', 'font-bold', 'mb-1', 'dark:text-gray-300']) for="pet-breed">Breed</label>
                <input 
                    id="pet-breed" 
                    wire:model="breed" 
                    type="text" 
                    @class(['w-full', 'border', 'p-2', 'rounded', 'dark:bg-gray-800', 'dark:border-gray-600', 'dark:text-white'])
                >
            </div>

            <!-- Date of Birth Input -->
            <!-- Selenium XPath: //*[@id='pet-dob'] -->
            <div>
                <label @class(['block', 'text-sm', 'font-bold', 'mb-1', 'dark:text-gray-300']) for="pet-dob">Birthday</label>
                <input 
                    id="pet-dob" 
                    wire:model="date_of_birth" 
                    type="date" 
                    @class(['w-full', 'border', 'p-2', 'rounded', 'dark:bg-gray-800', 'dark:border-gray-600', 'dark:text-white'])
                >
            </div>

            <!-- Weight Input -->
            <!-- Selenium XPath: //*[@id='pet-weight'] -->
            <div>
                <label @class(['block', 'text-sm', 'font-bold', 'mb-1', 'dark:text-gray-300']) for="pet-weight">Weight (kg)</label>
                <input 
                    id="pet-weight" 
                    wire:model="weight" 
                    type="number" 
                    step="0.01" 
                    @class(['w-full', 'border', 'p-2', 'rounded', 'dark:bg-gray-800', 'dark:border-gray-600', 'dark:text-white'])
                >
            </div>
        </div>

        <!-- Submit Button -->
        <!-- Selenium XPath: //*[@id='btn-add-pet'] -->
        <div class = "flex items-center gap-2 mt-4">
            <!-- Save Button (Green for edit, Blue for add) -->
            <button
                id = "btn-save"
                type = "submit"
                class = "px-4 py-2 rounded text-white font-bold transition {{ $editingPetId ? 'bg-green-500 hover:bg-green-600' : 'bg-blue-500 hover:bg-blue-600' }}"
            >
                {{ $editingPetId ? 'Update Pet' : 'Add Pet' }}
            </button>

            <!-- Cancel Edit Button (only shows in edit mode) -->
            @if ($editingPetId)
                <button
                    id = "btn-cancel"
                    type = "button"
                    wire:click = "cancelEdit"
                    class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold"
                >
                    Cancel
            </button>
                
            @endif
        </div>
    </form>

    <!-- LIST OF PETS (Keep existing code below) -->
    <div @class(['space-y-4']) id="pet-list">
        @foreach($pets as $pet)
            <div @class(['p-4', 'border', 'rounded', 'bg-gray-50', 'flex', 'justify-between', 'items-center', 'pet-item', 'dark:bg-gray-700', 'dark:border-gray-600'])>
                <div>
                    <h3 @class(['font-bold', 'text-lg', 'dark:text-white'])>{{ $pet->name }}</h3>
                    <p @class(['text-gray-600', 'dark:text-white'])>
                        {{ $pet->species }} 
                        • {{ $pet->breed ?? 'Unknown Breed' }}
                        @if($pet->date_of_birth)
                             • 🎂 {{ \Carbon\Carbon::parse($pet->date_of_birth)->format('M d, Y') }}
                        @endif
                    </p>
                </div>

                <div @class(['flex', 'items-center', 'space-x-2'])>
                    <span @class(['text-sm', 'text-gray-500', 'mr-4'])>
                        <!-- Shows how long ago the pet was added -->
                        {{ $pet->created_at->diffForHumans() }}
                    </span>

                    <!-- Edit Button -->
                    <button
                        wire:click = "editPet({{ $pet -> id }})"
                        id = "btn-edit-{{ $pet -> id }}"
                        class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded hover:bg-yellow-200 text-sm font-bold"
                    >
                        Edit
                    </button>

                    <!-- DELETE BUTTON -->
                    <!-- Selenium XPath: //*[@id='btn-delete-1'] (where 1 is the ID) -->
                    <!-- wire:click="deletePet(1)" calls the PHP function with ID 1 -->
                    <!-- wire:confirm adds a browser popup to ask "Are you sure?" -->
                    <button 
                        wire:click="deletePet({{ $pet->id }})"
                        wire:confirm="Are you sure you want to delete {{ $pet->name }}?"
                        id="btn-delete-{{ $pet->id }}"
                        @class(['bg-red-100', 'text-red-600', 'px-3', 'py-1', 'rounded', 'hover:bg-red-200', 'text-sm', 'font-bold'])
                    >
                        Delete
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
