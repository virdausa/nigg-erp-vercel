<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Employees') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl my-10 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        Employees
                    </h1>
                    <a href="{{ route('employees.create') }}">
                        <x-button type="button" class="mb-4" variant="primary">
                            Add New Employees
                        </x-button>
                    </a>

                    <x-table-table> 
                        <x-table-thead>
                            <tr>
                                <x-table-th>#</x-table-th>
                                <x-table-th>Employee Name</x-table-th>
                                <x-table-th>Registration Date</x-table-th>
                                <x-table-th>Out Date</x-table-th>
                                <x-table-th>Status</x-table-th>
                                <x-table-th>Role</x-table-th>
                                <x-table-th>Actions</x-table-th>
                            </tr>
                        </x-table-thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <x-table-td>{{ $loop->iteration }}</x-table-td>
                                    <x-table-td>{{ $employee->user->name }}</x-table-td>
                                    <x-table-td>{{ $employee->reg_date->format('Y-m-d') }}</x-table-td>
                                    <x-table-td>{{ $employee->out_date ? $employee->out_date->format('Y-m-d') : '-' }}</x-table-td>
                                    <x-table-td>
                                        {{ $employee->status ? 'Active' : 'Inactive' }}
                                    </x-table-td>
                                    <x-table-td>{{ $employee->role->name }}</x-table-td>
                                    <x-table-td>
                                        <a href="{{ route('employees.edit', $employee->id_employee) }}"
                                            class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                        <form action="{{ route('employees.destroy', $employee->id_employee) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                        </form>
                                    </x-table-td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-table-table>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>