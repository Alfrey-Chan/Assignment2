<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"> --}}

        <title>@yield('title')</title>

        {{-- styles --}}
        @stack('styles')

        {{-- vite directive allow us to include files without needing to manually move them to the public folder --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script
            src="https://kit.fontawesome.com/262aa8bad2.js"
            crossorigin="anonymous"
        ></script>
    </head>

    <body class="font-sans antialiased bg-zinc-100">
        <header>
            <nav class="bg-yellow-300">
                <ul>
                    <li>
                        <a
                            class="logo"
                            href="{{ route('transaction.index') }}"
                        >
                            <i
                                class="fa-solid fa-money-check-dollar fa-2xl"
                            ></i>
                            <span class="uppercase tracking-wider font-bold">
                                BusyBees
                            </span>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="login-logout"
                                onmouseover="this.children[0].classList.replace('fa-door-closed', 'fa-door-open')"
                                onmouseout="this.children[0].classList.replace('fa-door-open', 'fa-door-closed')"
                            >
                                <i class="fa-solid fa-door-closed fa-2xl"></i>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </header>

        {{-- In other view files, content nested inside a <x-layout> tag will be injected/pushed to $slot --}}
        {{ $slot }}

        <footer
            class="flex justify-center items-center bg-yellow-200 absolute bottom-0 w-full h-10 uppercase tracking-wider font-bold text-xs"
        >
            Alfrey Chan and Cheryl Lau
        </footer>
        {{-- scripts --}}
        @stack('scripts')
    </body>
</html>
