@push('styles')
    @vite('resources/css/index.css')
@endpush

<x-layout>
    <div class="flex flex-col w-full justify-center items-center">
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
        @if (session('success'))
            <div class="success text-green-500">
                {{ session('success') }}
            </div>
        @endif

        <x-functions
            :buttons="$buttons"
            :isAdmin="auth()->user() && auth()->user()->isAdmin()"
        />
        <div class="text-center my-4 text-xl text-black font-bold">Summary</div>
        <form method="GET" action="{{ route('transaction.summary') }}">
            <div class="flex w-full items-center justify-center gap-3">
                <label for="year" class="text-gray-900">Year:</label>
                <input
                    type="number"
                    name="year"
                    id="year"
                    value="{{ request('year') }}"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded p-2"
                    placeholder="Enter year"
                />
                <button
                    type="submit"
                    class="bg-yellow-300 rounded-md p-2 px-3 transform hover:scale-110 shadow-md"
                >
                    Filter
                </button>
            </div>
        </form>

         @if ($summary->count() == 0)
            <div class="text-center text-gray-800 m-4">
                No data available for the selected year.
            </div>
        @else
        <div class="flex justify-center w-full h-full rounded-lg my-4">
            <table
                style="border-radius: 1rem; overflow: hidden"
                class="w-4/5 md:w-3/4 lg:w-1/2 divide-y bg-white divide-gray-200 shadow-xl"
            >
                <thead class="text-center bg-white">
                    <th class="th">Category</th>
                    <th class="th">Total Spend</th>
                    <th class="th">Total Deposit</th>
                </thead>
                <tbody>
                    @foreach ($summary as $row)
                        <tr
                            class="items-center justify-center text-center text-gray-800 text-xs font-normal uppercase tracking-wider hover:bg-yellow-200"
                        >
                            <td class="py-6">{{ $row->category }}</td>
                            <td class="py-6 mx-6">
                                {{ $row->total_spend == 0 ? '-' : '$' . number_format($row->total_spend, 2) }}
                            </td>
                            <td class="py-6">
                                {{ $row->total_deposit == 0 ? '-' : '$' . number_format($row->total_deposit, 2) }}
                            </td>
                        </tr>
                    @endforeach

                    <tr
                        class="text-center text-gray-900 text-xs font-bold uppercase tracking-wider"
                    >
                        <td class="py-6">Total</td>
                        <td class="py-6 mx-6">
                            ${{ number_format($summary->sum('total_spend'), 2) }}
                        </td>
                        <td class="py-6">
                            ${{ number_format($summary->sum('total_deposit'), 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
       
                <div
                    id="chartContainer"
                    style="height: 370px; width: 100%"
                ></div>
        @endif
    </div>

    @php
        $dataPoints = [];
        foreach ($summary as $item) {
            $dataPoints[] = ['label' => $item->category, 'y' => $item->total_spend];
        }
        $year = request('year') ?? date('Y');
    @endphp

    @push('scripts')
        <script>
            var year = @json($year);
            var dataPoints = @json($dataPoints);
        </script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        @vite('resources/js/chart.js')
    @endpush
</x-layout>