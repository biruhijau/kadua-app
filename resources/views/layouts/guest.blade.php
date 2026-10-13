<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') &mdash; {{ config('app.name') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#C89B3C">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700|playfair-display:400,600,700&display=swap"
        rel="stylesheet" />

    <script>
        (function () {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased bg-white dark:bg-black text-black dark:text-white selection:bg-[#C89B3C] selection:text-white">
    <div class="absolute top-4 right-4 sm:top-6 sm:right-6 z-50">
        <x-theme-toggle />
    </div>

    <div class="min-h-screen w-full flex flex-col justify-center items-center px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="w-full max-w-[420px] mx-auto">
            <div class="flex justify-center mb-6">
                <a href="{{ route('login') }}" class="inline-block select-none outline-none focus:outline-none focus:ring-0" oncontextmenu="return false;">
                    <img src="{{ asset('images/kadua_light-mode.png') }}" alt="KADUA BY AMARTHA" draggable="false"
                        oncontextmenu="return false;"
                        class="pointer-events-none block h-16 w-auto max-w-[200px] select-none object-contain sm:h-20 sm:max-w-[240px] md:h-24 dark:hidden" />
                    <img src="{{ asset('images/kadua_dark-mode.png') }}" alt="KADUA BY AMARTHA" draggable="false"
                        oncontextmenu="return false;"
                        class="pointer-events-none hidden h-16 w-auto max-w-[200px] select-none object-contain sm:h-20 sm:max-w-[240px] md:h-24 dark:block" />
                </a>
            </div>

            {{ $slot }}
        </div>
    </div>
</body>

</html>
