<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Tambah Role Baru</h3>

                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Role</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label for="permissions" class="block text-sm font-medium text-gray-700">Permissions</label>
                            <select name="permissions[]" id="permissions" class="mt-1 block w-full border-gray-300 rounded-md" multiple>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
