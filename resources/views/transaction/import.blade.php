<x-layout>
    <form
        action="{{ route('transaction.import.csv') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        <div class="flex flex-col items-center">
            @csrf

            @if ($errors->any())
                <div class="error-messages text-red-400">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="text-center my-4 text-xl text-black font-bold">
                Import CSV
            </div>
            <div class="flex flex-col items-center gap-4">
                <div
                    class="flex flex-col justify-center items-center gap-2 mt-4"
                >
                    <label for="fileInput" class="font-bold">
                        Upload a CSV file to start organizing your finances!
                    </label>
                    <input
                        type="file"
                        name="csvFile"
                        id="fileInput"
                        class="bg-white rounded"
                    />
                </div>
                <div class="grid grid-cols-2 items-center gap-3 font-bold">
                    <button
                        type="button"
                        class="bg-yellow-200 rounded-md py-1 px-2 transform hover:scale-110 shadow-md col-span-1 text-gray-600"
                    >
                        <a href="{{ route('transaction.index') }}" class="btn">
                            <i class="fa-solid fa-left-long fa-l"></i>
                            Back
                        </a>
                    </button>

                    <button
                        type="button"
                        class="bg-yellow-300 rounded-md py-1 px-2 transform hover:scale-110 shadow-md col-span-1"
                    >
                        <input type="submit" value="Upload" name="submit" />
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-layout>
