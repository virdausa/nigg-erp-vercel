<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">ROLES</h3>

                    <a href="{{ route('roles.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
                        Tambah Role Baru
                    </a>

                    <table class="w-full border-collapse border border-gray-200 mt-4">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">#</th>
                                <th class="border px-4 py-2">Role Name</th>
                                <th class="border px-4 py-2">Permissions</th>
                                <th class="border px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $role->name }}</td>
                                    <td class="border px-4 py-2">
                                        @foreach ($role->permissions as $permission)
                                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-600 text-xs font-medium rounded-lg mr-1 mb-1">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('roles.edit', $role->id) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">
                                            ✏️
                                        </a>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
