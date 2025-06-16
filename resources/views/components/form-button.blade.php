<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-400'
    ]) }}
>
    {{ $slot }}
</button>