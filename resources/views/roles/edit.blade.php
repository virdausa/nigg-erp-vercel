<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Edit Role: {{ $role->name }}</h3>

                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Role</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <h4 class="text-md font-semibold">Permissions</h4>
                            @foreach ($groupedPermissions as $group => $permissions)
                                <div class="mb-4">
                                    <h5 class="text-sm font-bold text-gray-600 uppercase">{{ $group }}</h5>
                                    <div class="grid grid-cols-2 gap-2 mt-2">
                                        @foreach ($permissions as $permission)
                                            <label class="flex items-center space-x-2">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                                    @if ($role->permissions->contains($permission->id)) checked @endif
                                                    class="form-checkbox text-blue-500 rounded">
                                                <span>{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
