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

        <a href="{{ route('transaction.create') }}" class="btn ">
            New Transaction
        </a>
        <div class="flex justify-center">
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
                                <a href="{{ route('transaction.show', $transaction) }}" ><button class="btn bg-green-300 px-2">View</button></a>
                                <a href="{{ route('transaction.edit', $transaction) }}"><button class="btn bg-blue-400 px-3">Edit</button></a>
                                                                <form action="{{ route('transaction.destroy', $transaction) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn bg-red-400 px-1">Delete</button>
                                </form>
                            
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

           

        </div>

         <div class="flex justify-center w-full">
                {{ $transactions->links() }}
            </div>
    </div>
    
    @push('scripts')
        @vite('resources/js/index.js')
    @endpush
</x-layout>


