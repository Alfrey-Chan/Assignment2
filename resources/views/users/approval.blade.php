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
        <div class="text-center my-4 text-xl text-black font-bold">
            Approve Users
        </div>
        <div class="flex justify-center w-full h-full rounded-lg my-4">
            <table
                style="border-radius: 1rem; overflow: hidden"
                class="w-3/5 divide-y bg-white divide-gray-200 shadow-xl"
            >
                <thead class="text-center bg-white">
                    <th class="th">ID</th>
                    <th class="th">Name</th>
                    <th class="th">Email</th>
                    <th class="th">Approved</th>
                    <th class="th">Actions</th>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr
                            class="items-center justify-center text-center text-gray-800 text-xs font-normal uppercase tracking-wider hover:bg-yellow-200"
                        >
                            <td class="py-6">{{ $user->id }}</td>
                            <td class="py-6">{{ $user->name }}</td>
                            <td class="py-6">{{ $user->email }}</td>
                            <td class="py-6">
                                {{ $user->approved ? 'Yes' : 'No' }}
                            </td>
                            <td class="md:px-6">
                                <div
                                    class="flex gap-2 justify-center text-zinc-900"
                                >
                                    <form
                                        method="POST"
                                        action="{{ route('approve', ['user' => $user->id]) }}"
                                    >
                                        @csrf
                                        @if ($user->approved == false)
                                            <button
                                                type="submit"
                                                class="flex btn bg-green-300 w-7 h-7 p-2 justify-center items-center"
                                            >
                                                <i
                                                    class="fa-solid fa-check"
                                                ></i>
                                            </button>
                                        @else
                                            <button
                                                type="submit"
                                                class="flex btn bg-yellow-400 p-2 w-7 h-7 justify-center items-center"
                                            >
                                                <i class="fa-solid fa-x"></i>
                                            </button>
                                        @endif
                                    </form>

                                    <form
                                        action="{{ route('users.destroy', $user) }}"
                                        method="POST"
                                        class="delete-form"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="flex btn bg-red-400 p-2 w-7 h-7 justify-center items-center"
                                            onclick="return confirm('Are you sure you want to delete this user?')"
                                        >
                                            <i
                                                class="fa-solid fa-trash-can"
                                            ></i>
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
            {{ $users->links() }}
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/index.js')
    @endpush
</x-layout>
