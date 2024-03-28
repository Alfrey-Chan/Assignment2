<x-layout>
    @php
        $formLabel = 'block text-sm font-medium leading-6 text-gray-900';
        $formInput =
            'block flex-1 border rounded bg-white px-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 hover:cursor-pointer';
    @endphp

    <div class="text-center my-4 text-xl text-black font-bold">Login</div>

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="flex justify-center">
            <div class="flex flex-col items-center w-1/3 gap-4">
                <div class="grid grid-cols-4 items-center gap-2">
                    <label class="{{ $formLabel }}" for="email">Email:</label>
                    <input
                        class="{{ $formInput }} col-span-3"
                        type="email"
                        id="email"
                        name="email"
                        required
                    />

                    <label class="{{ $formLabel }}" for="password">
                        Password:
                    </label>
                    <input
                        class="{{ $formInput }} col-span-3"
                        type="password"
                        id="password"
                        name="password"
                        required
                    />
                </div>
                <div class="grid grid-cols-4 items-center gap-3 font-bold">
                    <a href="/" class="col-start-2 col-span-1">
                        <button
                            type="button"
                            class="bg-yellow-200 rounded-md py-1 px-2 transform hover:scale-110 shadow-md text-gray-600"
                        >
                            <i class="fa-solid fa-left-long fa-l"></i>
                            BACK
                        </button>
                    </a>

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
</x-layout>
