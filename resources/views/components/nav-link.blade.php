@props(['active' => false])

<a {{ $attributes }}
    class="{{ $active ? 'md:text-rose-800 bg-rose-800 md:bg-transparent' : 'hover:bg-rose-600 md:hover:bg-transparent md:hover:text-rose-800  hover:text-white border-rose-700' }} block py-2 px-3 text-white rounded-sm md:p-0"
    aria-current="{{ $active ? 'page' : false }}">{{ $slot }}</a>