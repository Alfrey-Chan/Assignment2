<x-layout>

    <form action="{{ route("transaction.import.csv") }}" method="POST" enctype="multipart/form-data">
        @csrf

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