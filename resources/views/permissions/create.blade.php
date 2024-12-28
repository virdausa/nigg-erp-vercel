<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Permission') }}
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-b border-gray-500 dark:bg-gray-800 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <h3 class="text-lg font-medium leading-tight">Buat Permission Baru</h3>

                    <form action="{{ route('permissions.store') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Permission</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required>
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
