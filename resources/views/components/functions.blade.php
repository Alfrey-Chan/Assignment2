@props([
    'buttons',
    'isAdmin',
])

<div class="w-3/5 flex my-4 gap-3 justify-center">
    @foreach ($buttons as $button)
        @if ($isAdmin || ! $button['adminOnly'])
            <a
                href="{{ $button['href'] }}"
                class="btn bg-yellow-200 py-2 px-4 font-bold"
            >
                {{ $button['text'] }}
            </a>
        @endif
    @endforeach
</div>
