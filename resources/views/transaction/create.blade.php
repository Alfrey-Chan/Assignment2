<x-layout>
    @php
        $formLabel = 'block text-sm font-medium leading-6 text-gray-900';
        $formInput =
            'block flex-1 border rounded bg-white px-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 hover:cursor-pointer';
    @endphp

    <div class="text-center my-4 text-xl text-black font-bold">
        New Transaction
    </div>

    <form action="{{ route('transaction.store') }}" method="POST">
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
                    <label for="date" class="{{ $formLabel }}">Date:</label>
                    <input
                        type="date"
                        id="date"
                        name="date"
                        class="{{ $formInput }} col-span-3"
                    />
                </div>
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
                    <label for="spend" class="{{ $formLabel }}">Spend:</label>
                    <input
                        type="text"
                        id="spend"
                        name="spend"
                        class="{{ $formInput }} col-span-3"
                    />
                </div>
                <div class="grid grid-cols-4 items-center gap-2">
                    <label for="deposit" class="{{ $formLabel }}">
                        Deposit:
                    </label>
                    <input
                        type="text"
                        id="deposit"
                        name="deposit"
                        class="{{ $formInput }} col-span-3"
                    />
                </div>
                <div class="grid grid-cols-4 items-center gap-2">
                    <label for="balance" class="{{ $formLabel }}">
                        Balance:
                    </label>
                    <input
                        type="text"
                        id="balance"
                        name="balance"
                        class="{{ $formInput }} col-span-3"
                    />
                </div>

                <div class="grid grid-cols-3 font-bold w-full">
                    <a class="w-full" href="/transaction">
                        <button
                            type="button"
                            class="w-full bg-yellow-200 rounded-md col-start-1 col-span-1 py-1 transform hover:scale-110 shadow-md text-gray-600"
                        >
                            <i class="fa-solid fa-left-long fa-l"></i>
                            Back
                        </button>
                    </a>

                    <button
                        class="rounded-md p-1 col-start-3 col-span-1 transform hover:scale-110 shadow-md bg-yellow-300"
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
