<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Info Manager</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Configure Tailwind to look for the 'dark' class -->
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<!-- 
    x-data: Initializes Alpine.js state.
    We check localStorage so the user's preference is remembered.
-->
<body 
    class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300 p-10"
    x-data="{ 
        darkMode: localStorage.getItem('darkMode') === 'true',
        toggle() { 
            this.darkMode = !this.darkMode; 
            localStorage.setItem('darkMode', this.darkMode);
            this.updateClass();
        },
        updateClass() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }"
    x-init="updateClass()"
>
    <div class="max-w-4xl mx-auto">
        
        <!-- Header with Theme Toggle -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                Pet Manager 🐾
            </h1>
            
            <!-- Selenium XPath: //*[@id='btn-theme-toggle'] -->
            <button 
                id="btn-theme-toggle"
                @click="toggle()" 
                class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold border border-gray-300 dark:border-gray-600 hover:bg-gray-300 dark:hover:bg-gray-600 transition"
            >
                <span x-text="darkMode ? '☀️ Light Mode' : '🌙 Dark Mode'"></span>
            </button>
        </div>

        <!-- Main Content Container -->
        <!-- Added dark:bg-gray-800 to make the card dark -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md transition-colors duration-300">
            {{ $slot }}
        </div>

    </div>
</body>
</html>
