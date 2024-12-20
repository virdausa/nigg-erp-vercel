<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Customers
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('customers.create') }}">
                        <x-button type="button" class="mb-4" variant="primary">
                            Add New Customer
                        </x-button>
                    </a>
                    <x-table>
                        <x-thead>
                            <tr>
                                <x-th>ID</x-th>
                                <x-th>Name</x-th>
                                <x-th>Email</x-th>
                                <x-th>Phone Number</x-th>
                                <x-th>Address</x-th>
                                <x-th>Status</x-th>
                                <x-th>Actions</x-th>
                            </tr>
                        </x-thead>
                        <tbody>
                            @foreach ($customers as $customer)
                            <x-trbody>
                                <x-td>{{ $customer->id }}</x-td>
                                <x-td>{{ $customer->name }}</x-td>
                                <x-td>{{ $customer->email }}</x-td>
                                <x-td>{{ $customer->phone_number }}</x-td>
                                <x-td>{{ $customer->address }}</x-td>
                                <x-td>{{ $customer->status }}</x-td>
                                <x-td class="flex justify-center items-center gap-2">
                                    <a href="{{ route('customers.edit', $customer->id) }}">
                                        <x-button type="button" variant="primary">
                                            Edit
                                        </x-button>
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">   
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" variant="danger" onclick="return confirm('Are you sure?')">
                                            Delete
                                        </x-button>
                                    </form>
                                </x-td>
                            </x-trbody>
                            @endforeach
                        </tbody>
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>