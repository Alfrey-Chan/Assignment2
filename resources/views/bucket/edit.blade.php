<x-layout>
    @php
        $formLabel = 'block text-sm font-medium leading-6 text-gray-900';
        $formInput =
            'block flex-1 border rounded bg-white px-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 hover:cursor-pointer';
    @endphp

    <div class="text-center my-4 text-xl text-white font-bold">Edit Bucket</div>

    <form action="{{ route('bucket.update', $bucket) }}" method="POST">
        @csrf
        @method('PUT')
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
                    <label
                        class="{{ $formLabel }}"
                        for="vendor"
                        class="bucket-vendor"
                    >
                        Vendor:
                    </label>
                    <input
                        class="{{ $formInput }} col-span-3"
                        type="text"
                        id="vendor"
                        name="vendor"
                        value="{{ $bucket->vendor }}"
                    />
                </div>

                <div class="grid grid-cols-4 items-center gap-2">
                    <label class="{{ $formLabel }}" for="spend">
                        Category:
                    </label>
                    <input
                        class="{{ $formInput }} col-span-3"
                        type="text"
                        id="category"
                        name="category"
                        value="{{ $bucket->category }}"
                    />
                </div>

                <div class="grid grid-cols-4 items-center gap-3 font-bold">
                    <button
                        type="button"
                        class="bg-yellow-200 rounded-md py-1 px-2 transform hover:scale-110 shadow-md col-start-1 col-span-1 text-gray-600"
                    >
                        <a href="/bucket">
                            <i class="fa-solid fa-left-long fa-l"></i>
                            BACK
                        </a>
                    </button>
                    <button
                        type="button"
                        class="bg-yellow-300 rounded-md py-1 px-2 transform hover:scale-110 shadow-md col-span-1"
                    >
                        <input type="submit" value="SAVE" />
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-layout>
