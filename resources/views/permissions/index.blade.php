<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white bg-white dark:bg-gray-800 dark:border-gray-700 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg dark:text-white font-bold">Role Access</h3>
                    <p class="text-sm dark:text-gray-200 mb-4">Atur role dan permission setiap fitur</p>

                    <div class="mx-auto max-w-screen-xl">
                        <div
                            class="bg-white border-b border-gray-500 dark:bg-gray-800 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                            <div
                                class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                                
                                <div
                                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                    <x-button-add :route="route('permissions.create')" text="Add Role" />
                                </div>
                            </div>
                            <div class="p-6 text-gray-900 dark:text-white">


                                <x-table-table id="permissions-table">
                                    <x-table-thead class="mt-3">
                                        <tr>
                                            <x-table-th>Nama Permission</x-table-th>
                                            <x-table-th>Aksi</x-table-th>
                                        </tr>
                                    </x-table-thead>
                                    <tbody>
                                        @foreach($permissions as $permission)
                                            <x-table-tr>
                                                <x-table-td>{{ $permission->name }}</x-table-td>
                                                <x-table-td>
                                                    <div class="flex inline">
                                                        <x-button-edit :route="route('permissions.edit', $permission->id)" />
                                                        <x-button-delete :route="route('permissions.destroy', $permission->id)" />
                                                    </div>
                                                </x-table-td>
                                            </x-table-tr>
                                        @endforeach
                                    </tbody>
                                </x-table-table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#permissions-table').DataTable({
            processing: true,   // Show processing indicator while loading
            serverSide: false,  // Set to true if you're loading data from server
            paging: true,       // Enable pagination
            pageLength: 10,     // Default number of rows per page
            lengthMenu: [10, 25, 50, 100],  // Dropdown for entries per page
            searching: true,    // Enable search functionality
            ordering: true,     // Enable column sorting
            order: [[0, 'asc']], // Set default sorting to the first column (ascending)
            responsive: true,   // Make table responsive on smaller screens
            language: {
                search: "Search:", // Customize search text
                paginate: {
                    previous: "Previous",
                    next: "Next"
                },
                lengthMenu: "Show _MENU_ entries",  // Customize entries per page text
                zeroRecords: "No matching records found"
            }
        });
    });
</script>

<!-- Apply Tailwind customizations -->
<style>
    /* Customizing the search box */
    .dataTables_filter input {
        @apply border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500;
    }

    /* Customizing the length menu dropdown */
    .dataTables_length select {
        @apply border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500;
    }

    /* Customizing the pagination buttons */
    .dataTables_paginate .paginate_button {
        @apply px-4 py-2 mx-1 text-sm rounded-lg bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500;
    }

    .dataTables_paginate .paginate_button.disabled {
        @apply bg-gray-200 text-gray-500 cursor-not-allowed;
    }
</style>


</x-app-layout>