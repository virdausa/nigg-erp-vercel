<x-app-layout>
    <div class="py-12">
        <div class="my-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        Add Customer
                    </h1>
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-900 dark:text-gray-100">Customer Name</label>
                                <x-input type="text" name="name" required x-model="name" />
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-900 dark:text-gray-100">Email</label>
                                <x-input type="email" name="email" x-model="email" />
                            </div>
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-900 dark:text-gray-100">Phone Number</label>
                                <x-input type="text" name="phone_number" required x-model="phone_number" />
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-900 dark:text-gray-100">Address</label>
                                <x-input name="address" x-model="address" />
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-900 dark:text-gray-100">Status</label>
                                <select name="status" x-model="status" class='flex h-9 w-full rounded-md border border-gray-900 dark:border-gray-100 bg-transparent px-3 py-1 text-gray-900 dark:text-gray-100 shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm'>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-900 dark:text-gray-100">Note</label>
                                <textarea class='flex h-9 w-full rounded-md border border-gray-900 dark:border-gray-100 bg-transparent px-3 py-1 text-gray-900 dark:text-gray-100 shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm' name="notes" x-model="notes"></textarea>
                            </div>
                            <div class="flex gap-3 justify-end">
                                <a href="{{ route('customers.index') }}">
                                    <x-button type="button" variant="secondary">Cancel</x-button>
                                </a>
                                <x-button type="submit" variant="primary">Create Customer</x-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>