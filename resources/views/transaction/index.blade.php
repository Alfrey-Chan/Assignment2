@push('styles')
    @vite('resources/css/index.css')
@endpush

<x-layout>
    <div class="flex flex-col w-full justify-center items-center font-bold">
        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <div class="w-4/5 flex my-4">
            <a
                href="{{ route('transaction.create') }}"
                class="btn bg-yellow-200 py-2 px-4"
            >
                New Transaction
            </a>
        </div>
        <div class="text-center my-4 text-xl text-black">Transactions</div>
        <div class="flex justify-center w-full h-full rounded-lg my-4">
            <table
                style="border-radius: 1rem; overflow: hidden"
                class="w-4/5 md:w-3/4 lg:w-1/2 divide-y divide-gray-200 shadow-xl"
            >
                <thead class="text-center bg-white">
                    @for ($i = 1; $i <= 7; $i++)
                        <th class="th">{{ $headers[$i] }}</th>
                    @endfor

                    <th class="th">Actions</th>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr
                            class="{{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-white' }} text-center text-gray-800 text-xs font-normal uppercase tracking-wider hover:bg-yellow-200"
                        >
                            <td class="py-6">{{ $transaction->id }}</td>
                            <td class="py-6">{{ $transaction->date }}</td>
                            <td class="py-6">{{ $transaction->vendor }}</td>
                            <td class="py-6">{{ $transaction->category }}</td>
                            <td class="py-6 mx-6">
                                {{ $transaction->spend }}
                            </td>
                            <td class="py-6">{{ $transaction->deposit }}</td>
                            <td class="py-6">{{ $transaction->balance }}</td>
                            <td class="md:px-6">
                                <div
                                    class="flex gap-2 justify-center text-zinc-900"
                                >
                                    <a
                                        href="{{ route('transaction.edit', $transaction) }}"
                                    >
                                        <button class="btn px-3">EDIT</button>
                                    </a>
                                    <form
                                        action="{{ route('transaction.destroy', $transaction) }}"
                                        method="POST"
                                        class="delete-form"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn bg-red-400 px-2"
                                            onclick="return confirm('Are you sure you want to delete this transaction?')"
                                        >
                                            DELETE
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-center w-full my-4">
            {{ $transactions->links() }}
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/index.js')
    @endpush
</x-layout>
