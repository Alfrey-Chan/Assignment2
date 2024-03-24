<x-layout>

    <form action="{{ route("transaction.import.csv") }}" method="POST" enctype="multipart/form-data">
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

        <div class="form-field">
            <label for="fileInput">Upload a CSV file to start organizing your finances!</label>
            <input type="file" name="csvFile" id="fileInput">
        </div>

        <div class="action-btns">
            <a href="{{ route('transaction.index') }}" class="btn">Back</a>
            <input type="submit" value="Upload" name="submit"/>
        </div>
    </form>

</x-layout>