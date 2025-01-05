<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sales Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <h3 class="text-lg font-bold dark:text-white mb-4">Manage Sales Orders</h3>
                    <p class="text-sm dark:text-gray-200 mb-6">Create, edit, and manage your sales orders.</p>

                    <div
                        class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 mb-4">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center" method="GET" action="{{ route('sales.index') }}">
                                <label for="search-sales" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="search-sales" name="query" placeholder="Search Sales"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                </div>
                                {{-- <button type="submit" class="btn btn-primary ml-2">Search</button> --}}
                            </form>
                        </div>

                        <div class="w-full md:w-auto flex justify-end">
                            <a href="{{ route('sales.create') }}">
                                <x-button-add :route="route('sales.create')" text="Add Sale" />
                            </a>
                            <a href="{{ route('customer_complaints.index') }}" class="ml-2">
                                <x-secondary-button :route="route('customer_complaints.index')">Customer Complaint</x-secondary-button>
                            </a>
                        </div>
                    </div>

                    <x-table-table>
                        <x-table-thead>
                            <tr>
                                <x-table-th>Customer</x-table-th>
                                <x-table-th>Sale Date</x-table-th>
                                <x-table-th>Warehouse</x-table-th>
                                <x-table-th>Total Amount</x-table-th>
                                <x-table-th>Products</x-table-th>
                                <x-table-th>Status</x-table-th>
                                <x-table-th>Actions</x-table-th>
                            </tr>
                        </x-table-thead>
                        <x-table-tbody>
                            @foreach ($sales as $sale)
                                <x-table-tr>
                                    <x-table-td>{{ $sale->customer->name ?? '' }}</x-table-td>
                                    <x-table-td>{{ $sale->sale_date }}</x-table-td>
                                    <x-table-td>{{ $sale->warehouse->name }}</x-table-td>
                                    <x-table-td>${{ $sale->total_amount }}</x-table-td>
                                    <x-table-td>
                                        <ul>
                                            @foreach ($sale->products as $product)
                                                <li>{{ $product->name }} - {{ $product->pivot->quantity }} pcs @
                                                    {{ $product->pivot->price }}
                                                    ({{ $product->pivot->note ?? 'No Note' }})
                                                </li>
                                            @endforeach
                                        </ul>
                                    </x-table-td>
                                    <x-table-td>{{ $sale->status }}</x-table-td>
                                    <x-table-td>
                                        <div class="flex items-center space-x-2">
                                            <x-button-show :route="route('sales.show', $sale->id)" />
                                            <x-button-edit :route="route('sales.edit', $sale->id)" />
                                            @if ($sale->status == 'Planned')
                                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button-delete :route="route('sales.destroy', $sale->id)" />
                                                </form>
                                            @endif
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
