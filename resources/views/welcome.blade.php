<x-layout>
    <div class="flex flex-col items-center justify-center h-screen">
        <h1 class="text-4xl font-bold text-center text-black dark:text-white">
            Welcome to BusyBees
        </h1>
        <!DOCTYPE html>

        <div class="flex flex-col gap-2">
            <div class="bg-white rounded p-4 my-7">
                Please either login or register to continue.
            </div>
            <div class="flex w-full justify-center gap-7">
                <a class="w-1/2" href="{{ route('login') }}">
                    <button
                        class="bg-yellow-300 rounded-md p-2 transform hover:scale-110 shadow-md w-full"
                    >
                        Login
                    </button>
                </a>
                <a class="w-1/2" href="{{ route('register') }}">
                    <button
                        class="bg-yellow-300 rounded-md p-2 transform hover:scale-110 shadow-md w-full"
                    >
                        Register
                    </button>
                </a>
            </div>
        </div>
    </div>
</x-layout>
