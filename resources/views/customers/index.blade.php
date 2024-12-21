<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl my-10 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        Customer
                    </h1>
                    <a href="{{ route('customers.create') }}">
                        <x-button type="button" class="mb-4" variant="primary">
                            Add New Customer
                        </x-button>
                    </a>
                    <x-table-table>
                        <x-table-thead>
                            <tr>
                                <x-table-th>ID</x-table-th>
                                <x-table-th>Name</x-table-th>
                                <x-table-th>Email</x-table-th>
                                <x-table-th>Phone Number</x-table-th>
                                <x-table-th>Address</x-table-th>
                                <x-table-th>Status</x-table-th>
                                <x-table-th>Reg Date</x-table-th>
                                <x-table-th>Actions</x-table-th>
                            </tr>
                        </x-table-thead>
                        <x-table-tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <x-table-td>{{ $customer->id }}</x-table-td>
                                    <x-table-td>{{ $customer->name }}</x-table-td>
                                    <x-table-td>{{ $customer->email }}</x-table-td>
                                    <x-table-td>{{ $customer->phone_number }}</x-table-td>
                                    <x-table-td>{{ $customer->address }}</x-table-td>
                                    <x-table-td>{{ $customer->status }}</x-table-td>
                                    <x-table-td>{{ $customer->created_at }}</x-table-td>
                                    <x-table-td class="flex justify-center items-center gap-2">
                                        <a href="{{ route('customers.edit', $customer->id) }}">
                                            <x-button type="button" variant="primary">
                                                Edit
                                            </x-button>
                                        </a>
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" variant="danger"
                                                onclick="return confirm('Are you sure?')">
                                                Delete
                                            </x-button>
                                        </form>
                                    </x-table-td>
                                </tr>
                            @endforeach
                        </x-table-tbody>
                    </x-table-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
