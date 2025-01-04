<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
            {{ __('Warehouse List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <h1 class="text-2xl font-bold mb-6">Warehouse List</h1>

                    <!-- Actions -->
                   
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-4">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <label for="search-supplier-name" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="search-supplier-name" placeholder="Search" required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                </div>
                            </form>
                        </div>
                        <div class="flex flex-col md:flex-row items-center space-x-3">
                            <x-responsive-nav-link :href="route('locations.index')" class="rounded-lg bg-emerald-800 hover:bg-emerald-600 dark:hover:bg-emerald-900 text-white text-lg ">
                                    {{ __(key: 'Manage Location') }}
                                </x-responsive-nav-link>
                                @include('warehouses.create')
                         </div>
                    </div>

                    <!-- Warehouse Table -->
                    <x-table-table>
                        <x-table-thead>
                            <tr>
                                <x-table-th>ID</x-table-th>
                                <x-table-th>Name</x-table-th>
                                <x-table-th>Location</x-table-th>
                                <x-table-th>Actions</x-table-th>
                            </tr>
                        </x-table-thead>
                        <x-table-tbody>
                            @foreach ($warehouses as $warehouse)
                                <x-table-tr>
                                    <x-table-td>{{ $warehouse->id }}</x-table-td>
                                    <x-table-td>{{ $warehouse->name }}</x-table-td>
                                    <x-table-td>{{ $warehouse->location }}</x-table-td>
                                    <x-table-td>
                                        <div class="flex items-center space-x-2">
                                            
                                            @include('warehouses.edit', ['warehouse' => $warehouse])
                                            <x-button-delete :route="route('warehouses.destroy', $warehouse->id)" />
                                        </div>
                                    </x-table-td>
                                </x-table-tr>
                            @endforeach
                        </x-table-tbody>
                    </x-table-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
