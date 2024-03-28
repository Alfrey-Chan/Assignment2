<x-layout>
    @php
        $formLabel = 'block text-sm font-medium leading-6 text-gray-900';
        $formInput =
            'block flex-1 border rounded bg-white px-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 hover:cursor-pointer';
    @endphp

    <div class="text-center my-4 text-xl text-white font-bold">New Bucket</div>

    <form action="{{ route('bucket.store') }}" method="POST">
        @csrf
        <div class="flex flex-col items-center">
            <div class="flex flex-col items-center mb-4">
                @if ($errors->any())
                    <div class="error-messages text-red-400">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="flex flex-col w-1/3 gap-2">
                <div class="grid grid-cols-4 items-center gap-2">
                    <label for="vendor" class="{{ $formLabel }}">
                        Vendor:
                    </label>
                    <input
                        type="text"
                        id="vendor"
                        name="vendor"
                        class="{{ $formInput }} col-span-3"
                    />
                </div>
                <div class="grid grid-cols-4 items-center gap-2">
                    <label for="category" class="{{ $formLabel }}">
                        Category:
                    </label>
                    <input
                        type="text"
                        id="category"
                        name="category"
                        class="{{ $formInput }} col-span-3"
                    />
                </div>
                <div class="grid grid-cols-4 items-center gap-3 font-bold">
                    <button
                        type="button"
                        class="bg-yellow-200 rounded-md py-1 px-2 transform hover:scale-110 shadow-md col-start-2 col-span-1 text-gray-600"
                    >
                        <a href="/bucket">
                            <i class="fa-solid fa-left-long fa-l"></i>
                            BACK
                        </a>
                    </button>
                    <button
                        class="rounded-md p-1 px-2 transform hover:scale-110 shadow-md bg-yellow-300 col-span-1"
                        type="button"
                    >
                        <input class="font-bold" type="submit" value="Submit" />
                    </button>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        @vite('resources/js/create.js')
    @endpush
</x-layout>
