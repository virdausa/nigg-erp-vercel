@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-300' ]) }}>
<style>
    ::-webkit-calendar-picker-indicator {
    /* filter: invert(1); */
}
</style>