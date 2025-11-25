@props(['tab' => null])

<header class="relative bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight">
            <span class="{{ $tab ? 'text-gray-500' : 'text-gray-900' }}">
                {{ $slot }}
            </span>

            @if ($tab)
                <span class="mx-2 text-sm text-gray-400 align-middle">&gt;</span>
                <span class="text-gray-900">{{ ucfirst($tab) }}</span>
            @endif
        </h1>
    </div>
</header>
