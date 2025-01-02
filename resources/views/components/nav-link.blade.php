<div x-data="{ isOpen: false }" class="relative">
    <!-- Trigger Button -->
    <button @click="isOpen = true" {{ $attributes->merge(['class' => 'px-4 py-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-700']) }}>
        {{ $trigger }}
    </button>

    <!-- Modal Dialog -->
    <div x-show="isOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-3xl p-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $title }}</h3>
                <button @click="isOpen = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    &times;
                </button>
            </div>

            <!-- Modal Content -->
            <div>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
