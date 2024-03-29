<x-layout>
    <div class="flex flex-col items-center justify-center h-screen">
        <h1 class="text-4xl font-bold text-center text-black dark:text-white">
            Welcome to BusyBees
        </h1>
        <!DOCTYPE html>

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
</x-layout>
