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

            <!-- Image Upload Input -->
            <!-- Selenium XPath: //*[@id='pet-image'] -->
            <div class="col-span-2 border-t pt-4 mt-2 dark:border-gray-600">
                <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="pet-image">
                    Upload Photo
                </label>
                
                <input
                    id="pet-image"
                    wire:model="image"
                    type="file"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:text-gray-300 dark:file:bg-gray-700 dark:file:text-gray-300"
                >
                @error('image') <span id="error-image" class="text-red-500 text-xs">{{ $message }}</span> @enderror

                <!-- Live Preview (Shows immediately after selecting a file) -->
                <!-- Selenium XPath: //*[@id='preview-image'] -->
                @if ($image)
                    <div class="mt-4">
                        <p class="text-xs text-gray-500 mb-1">Preview:</p>
                        <img id="preview-image" src="{{ $image->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-lg border shadow-sm">
                    </div>
                @endif
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
                        <!-- Pet Card Item -->
            <div class="p-4 border rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 flex justify-between items-center pet-item transition-colors">
                
                <!-- LEFT SIDE: Image + Text Info -->
                <div class="flex items-center gap-4">
                    
                    <!-- Pet Image -->
                    <!-- Selenium XPath: //*[@id='img-pet-1'] -->
                    
                    @if($pet->image)
                        <img 
                            src="{{ asset('storage/' . $pet->image) }}" 
                            alt="{{ $pet->name }}" 
                            class="w-16 h-16 object-cover rounded-full border-2 border-white dark:border-gray-600 shadow-sm"
                            id="img-pet-{{ $pet->id }}"
                        >
                    @else
                        <!-- Placeholder Circle if no image -->
                        <div class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center text-2xl border-2 border-white dark:border-gray-500">
                            🐾
                        </div>
                    @endif

                    <!-- Pet Details -->
                    <div>
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white">{{ $pet->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            {{ $pet->species }} 
                            • {{ $pet->breed ?? 'Unknown Breed' }}
                            @if($pet->date_of_birth)
                                 • 🎂 {{ $pet->date_of_birth->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                </div>

                <!-- RIGHT SIDE: Buttons (Edit/Delete) -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400 mr-4 hidden sm:inline">
                        {{ $pet->created_at->diffForHumans() }}
                    </span>

                    <button 
                        wire:click="editPet({{ $pet->id }})"
                        id="btn-edit-{{ $pet->id }}"
                        class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded hover:bg-yellow-200 text-sm font-bold dark:bg-yellow-900 dark:text-yellow-200 dark:hover:bg-yellow-800"
                    >
                        Edit
                    </button>

                    <button 
                        wire:click="deletePet({{ $pet->id }})"
                        wire:confirm="Are you sure?"
                        id="btn-delete-{{ $pet->id }}"
                        class="bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 text-sm font-bold dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800"
                    >
                        Delete
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
