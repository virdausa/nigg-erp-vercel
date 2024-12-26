@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-gray-900 dark:text-gray-100']) }}>
    {{ $value ?? $slot }}
</label>
