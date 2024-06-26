<x-layout>
    <div class="flex flex-col items-center justify-center h-screen">
        <h1 class="text-4xl font-bold text-center text-black">
            Welcome to BusyBees
        </h1>
        <!DOCTYPE html>

        @if (session('message'))
            <div class="success text-green-500">
                {{ session('message') }}
            </div>
        @endif

        <div class="flex flex-col gap-2 items-center">
            <div
                class="rounded p-4 my-7 text-xs font-normal uppercase tracking-wider"
            >
                Tracking your finances
            </div>
            <div class="grid grid-cols-4 w-full justify-center gap-7">
                <a
                    class="w-full col-start-2 col-span-1"
                    href="{{ route('login') }}"
                >
                    <button
                        class="bg-yellow-300 rounded-md p-2 px-4 transform hover:scale-110 shadow-md w-full"
                    >
                        Login
                    </button>
                </a>
                <a class="w-full col-span-1" href="{{ route('register') }}">
                    <button
                        class="bg-yellow-300 rounded-md p-2 px-4 transform hover:scale-110 shadow-md w-full"
                    >
                        Register
                    </button>
                </a>
            </div>
        </div>
    </div>
    <footer
            class="flex justify-center items-center bg-yellow-200 sticky bottom-0 w-full h-10 uppercase tracking-wider font-bold text-xs"
        >
            Alfrey Chan and Cheryl Lau
        </footer>
</x-layout>
