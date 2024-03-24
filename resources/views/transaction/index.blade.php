@push('styles')
    @vite('resources/css/index.css')
@endpush

<x-layout>
    <div class="transaction-container">

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('transaction.create') }}" class="new-transaction-btn">
            New Transaction
        </a>
        <div class="transactions">
            <table class="content-table">
                <thead>
                    <th>{{ $headers[0] }}</th> {{-- id --}}
                    <th>{{ $headers[1] }}</th> {{-- date --}}
                    <th>{{ $headers[2] }}</th> {{-- vendor --}}
                    <th>{{ $headers[3] }}</th> {{-- category --}}
                    <th>{{ $headers[4] }}</th> {{-- spend --}}
                    <th>{{ $headers[5] }}</th> {{-- deposit --}}
                    <th>{{ $headers[6] }}</th> {{-- balance --}}
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)  
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->date }}</td>
                        <td>{{ $transaction->vendor }}</td> 
                        <td>{{ $transaction->category }}</td>
                        <td>{{ $transaction->spend }}</td>
                        <td>{{ $transaction->deposit }}</td>
                        <td>{{ $transaction->balance }}</td>
                        <td>
                            <div class="flex gap-2">
                                <a href="{{ route('transaction.show', $transaction) }}" ><button class="bg-green-300 rounded py-1 px-2">View</button></a>
                                <a href="{{ route('transaction.edit', $transaction) }}"><button class="bg-blue-400 rounded px-3  py-1">Edit</button></a>
                                <form action="{{ route('transaction.destroy', $transaction) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-400 rounded p-1" 
                                        onclick="return confirm('Are you sure you want to delete this transaction?')">
                                        Delete
                                    </button>
                                </form>
                            
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination-container">
                {{ $transactions->links() }}
            </div>

        </div>
    </div>
    
    @push('scripts')
        @vite('resources/js/index.js')
    @endpush
</x-layout>


