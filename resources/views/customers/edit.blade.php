<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Customer
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                                <x-input type="text" name="name" x-model="name" required value="{{ $customer->name }}" />
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <x-input type="email" name="email" x-model="email" value="{{ $customer->email }}" required />
                            </div>
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <x-input type="text" name="phone_number" x-model="phone_number" value="{{ $customer->phone_number }}" required />
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <x-input name="address" x-model="address" value="{{ $customer->address }}" />
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" x-model="status" required class='flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm'>
                                    <option value="Active" {{ $customer->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $customer->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea name="notes" x-model="notes" class='flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:text-sm'>{{ $customer->notes }}</textarea>
                            </div>
                        </div>
                        <div class="flex gap-3 justify-end mt-4">
                            <a href="{{ route('customers.index') }}">
                                <x-button type="button" variant="secondary">
                                    Cancel
                                </x-button>
                            </a>
                            <x-button type="submit" variant="primary">Update Customer</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>