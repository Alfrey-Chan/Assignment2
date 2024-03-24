<x-layout>
    <div class="transaction-edit">
        <h1>Edit Transaction</h1>

        <form
            action="{{ route('transaction.update', $transaction) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="error-messages">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2><strong>ID: {{ $transaction->id }}</strong></h2>

            <div class="form-field">
                <label for="date" class="transaction-date">Date</label>
                <input
                    type="date"
                    id="date"
                    name="date"
                    value="{{ $transaction->date }}"
                />
            </div>

            <div class="form-field">
                <label for="vendor" class="transaction-vendor">Vendor</label>
                <input
                    type="text"
                    id="date"
                    name="vendor"
                    value="{{ $transaction->vendor }}"
                />
            </div>

            <div class="form-spend">
                <label for="spend" class="transaction-spend">Spend</label>
                <input
                    type="text"
                    id="spend"
                    name="spend"
                    value="{{ $transaction->spend }}"
                />
            </div>

            <div class="form-field">
                <label for="deposit" class="transaction-deposit">Deposit</label>
                <input
                    type="text"
                    id="deposit"
                    name="deposit"
                    value="{{ $transaction->deposit }}"
                />
            </div>

            <div class="form-field">
                <label for="balance" class="transaction-balance">Balance</label>
                <input
                    type="text"
                    id="balance"
                    name="balance"
                    value="{{ $transaction->balance }}"
                />
            </div>

            <div class="form-field">
                <a href="{{ url()->previous() }}">BACK</a>
                <input type="submit" value="SAVE" />
            </div>
        </form>
    </div>

    @push('scripts')
        @vite('resources/js/create.js')
    @endpush
</x-layout>
