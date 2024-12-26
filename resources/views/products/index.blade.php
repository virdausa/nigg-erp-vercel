<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl my-10 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        Products
                    </h1>
                    <a href="{{ route('products.create') }}">
                        <x-button type="button" class="mb-4" variant="primary">
                            Add Products
                        </x-button>
                    </a>
                    <x-table-table>
                        <x-table-thead>
                            <tr>
                                <x-table-th>ID</x-table-th>
                                <x-table-th>Name</x-table-th>
                                <x-table-th>Sku</x-table-th>
                                <x-table-th>Price</x-table-th>
                                <x-table-th>Weight</x-table-th>
                                <x-table-th>Status</x-table-th>
                                <x-table-th>Notes</x-table-th>
                                <x-table-th>Actions</x-table-th>
                            </tr>
                        </x-table-thead>
                        <x-table-tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <x-table-td>{{ $product->id }}</x-table-td>
                                    <x-table-td>{{ $product->name }}</x-table-td>
                                    <x-table-td>{{ $product->sku }}</x-table-td>
                                    <x-table-td>{{ $product->price }}</x-table-td>
                                    <x-table-td>{{ $product->weight }}</x-table-td>
                                    <x-table-td>{{ $product->status }}</x-table-td>
                                    <x-table-td>{{ $product->notes }}</x-table-td>
                                    <x-table-td class="flex justify-center items-center gap-2">
                                        <a href="{{ route('products.edit', $product->id) }}">
                                            <x-button type="button" variant="primary">
                                                Edit
                                            </x-button>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
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
