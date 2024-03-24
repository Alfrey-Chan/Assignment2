<x-layout>
    @php
        $formLabel = 'block text-sm font-medium leading-6 text-gray-900';
        $formInput =
            'block flex-1 border rounded bg-white px-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 hover:cursor-pointer';
    @endphp

    <div class="text-center my-4 text-xl text-black font-bold">
        Edit Transaction
    </div>

    <form
        action="{{ route('transaction.update', $transaction) }}"
        method="POST"
    >
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
                    <label class="{{ $formLabel }}" for="date">Date:</label>
                    <input
                        class="{{ $formInput }} col-span-3"
                        type="date"
                        id="date"
                        name="date"
                        value="{{ $transaction->date }}"
                    />
                </div>

                <div class="grid grid-cols-4 items-center gap-2">
                    <label
                        class="{{ $formLabel }}"
                        for="vendor"
                        class="transaction-vendor"
                    >
                        Vendor:
                    </label>
                    <input
                        class="{{ $formInput }} col-span-3"
                        type="text"
                        id="date"
                        name="vendor"
                        value="{{ $transaction->vendor }}"
                    />
                </div>

                <div class="grid grid-cols-4 items-center gap-2">
                    <label class="{{ $formLabel }}" for="spend">Spend:</label>
                    <input
                        class="{{ $formInput }} col-span-3"
                        type="text"
                        id="spend"
                        name="spend"
                        value="{{ $transaction->spend }}"
                    />
                </div>

                <div class="grid grid-cols-4 items-center gap-2">
                    <label
                        class="{{ $formLabel }}"
                        for="deposit"
                        class="transaction-deposit"
                    >
                        Deposit:
                    </label>
                    <input
                        class="{{ $formInput }} col-span-3"
                        type="text"
                        id="deposit"
                        name="deposit"
                        value="{{ $transaction->deposit }}"
                    />
                </div>

                <div class="grid grid-cols-4 items-center gap-2">
                    <label
                        class="{{ $formLabel }}"
                        for="balance"
                        class="transaction-balance"
                    >
                        Balance:
                    </label>
                    <input
                        class="{{ $formInput }} col-span-3"
                        type="text"
                        id="balance"
                        name="balance"
                        value="{{ $transaction->balance }}"
                    />
                </div>

                <div class="grid grid-cols-4 items-center gap-3 font-bold">
                    <button
                        type="button"
                        class="bg-yellow-200 rounded-md py-1 px-2 transform hover:scale-110 shadow-md col-span-2 text-gray-600"
                    >
                        <a href="/transaction">
                            <i class="fa-solid fa-left-long fa-l"></i>
                            BACK
                        </a>
                    </button>
                    <button
                        type="button"
                        class="bg-yellow-300 rounded-md py-1 px-2 transform hover:scale-110 shadow-md col-span-2"
                    >
                        <input type="submit" value="SAVE" />
                    </button>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        @vite('resources/js/create.js')
    @endpush
</x-layout>
