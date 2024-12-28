<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-b border-gray-500 dark:bg-gray-800 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <h3 class="text-lg font-medium leading-tight">Daftar Permissions</h3>

                    <a href="{{ route('permissions.create') }}" class="text-blue-500 hover:text-blue-700">Tambah Permission Baru</a>

                    <table class="mt-4 w-full text-left">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b">Nama Permission</th>
                                <th class="px-4 py-2 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $permission->name }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <a href="{{ route('permissions.edit', $permission->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
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
