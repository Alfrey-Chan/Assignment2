<x-layout>
    <h1>create</h1>

    <form action="{{ route('transaction.store') }}" method="POST">
        @csrf

        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" />

        <label for="vendor">Vendor:</label>
        <input type="text" id="vendor" name="vendor" />

        <label for="spend">Spend:</label>
        <input type="text" id="spend" name="spend" />

        <label for="deposit">Deposit</label>
        <input type="text" id="deposit" name="deposit" />

        <label for="balance">Balance</label>
        <input type="text" id="balance" name="balance" />

        <input type="submit" value="Submit" />
    </form>

    @push('scripts')
        @vite('resources/js/create.js')
    @endpush
</x-layout>
