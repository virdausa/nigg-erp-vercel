<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl my-10 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        Edit Product: {{ $product->name }}
                    </h1>
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Product Name')" />
                                <x-input-input type="text" name="name" x-model="name" required
                                    value="{{ $product->name }}" />
                            </div>
                            <div>
                                <x-input-label for="sku" :value="__('SKU')" />
                                <x-input-input type="text" name="sku" x-model="sku" value="{{ $product->sku }}"
                                    required />
                            </div>
                            <div>
                                <x-input-label for="price" :value="__('Phone Number')" />
                                <x-input-input type="number" name="price" x-model="price"
                                    value="{{ $product->price }}" required />
                            </div>
                            <div>
                                <x-input-label for="weight" :value="__('Weight')" />
                                <x-input-input name="weight" x-model="weight" value="{{ $product->weight }}" />
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <x-input-select name="status" x-model="status" required>
                                    <x-select-option value="Active" :selected="$product->status === 'Active'">Active</x-select-option>
                                    <x-select-option value="Inactive" :selected="$product->status === 'Inactive'">Inactive</x-select-option>
                                </x-input-select>
                            </div>
                            <div>
                                <x-input-label for="notes" :value="__('Notes')" />
                                <x-input-textarea name="notes"
                                    x-model="notes">{{ $product->notes }}</x-input-textarea>
                            </div>
                        </div>
                        <div class="flex gap-3 justify-end mt-4">
                            <a href="{{ route('products.index') }}">
                                <x-button type="button" variant="secondary">
                                    Cancel
                                </x-button>
                            </a>
                            <x-button type="submit" variant="primary">Update product</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
