@props(['href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'flex items-center justify-center font-medium rounded-lg text-sm px-4 py-2']) }}>
    @isset($icon)
        <span class="icon">
            {{ $icon }}
        </span>
    @endisset
    <span class="content">
        {{ $slot }}
    </span>
</a>
