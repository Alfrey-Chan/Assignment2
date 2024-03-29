<x-layout>
    <div class="flex flex-col items-center justify-center h-screen gap-4">
        <h1 class="text-4xl font-bold text-center text-black dark:text-white">
            Bzz Bzz...your registration is still pending approval
        </h1>
        <div class="flex w-full justify-center">
            <a class="w-1/4" href="{{ route('welcome') }}">
                <button
                    class="bg-yellow-300 rounded-md p-2 px-4 transform hover:scale-110 shadow-md w-full"
                >
                    Take me back
                </button>
            </a>
        </div>
    </div>
</x-layout>
