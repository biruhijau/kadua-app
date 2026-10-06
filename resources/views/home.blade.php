<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-200 antialiased">
    <main class="mx-auto flex min-h-screen max-w-3xl flex-col items-center justify-center px-6 text-center">
        <span class="mb-6 inline-flex items-center rounded-full border border-neutral-800 px-3 py-1 text-xs font-medium tracking-wide text-neutral-400">
            Laravel {{ Illuminate\Foundation\Application::VERSION }} &middot; PHP {{ PHP_VERSION }}
        </span>

        <h1 class="text-4xl font-semibold tracking-tight text-white sm:text-5xl">
            {{ config('app.name', 'Laravel') }}
        </h1>

        <p class="mt-4 max-w-md text-sm leading-relaxed text-neutral-400">
            Aplikasi berjalan dengan baik. Mulai bangun sesuatu yang hebat dari sini.
        </p>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-3">
            <a href="https://laravel.com/docs" target="_blank" rel="noopener noreferrer"
               class="rounded-lg bg-white px-4 py-2 text-sm font-medium text-neutral-950 transition hover:bg-neutral-200">
                Dokumentasi
            </a>
            <a href="https://laravel.com/docs/routing" target="_blank" rel="noopener noreferrer"
               class="rounded-lg border border-neutral-800 px-4 py-2 text-sm font-medium text-neutral-300 transition hover:border-neutral-700 hover:text-white">
                Routing
            </a>
        </div>
    </main>
</body>
</html>
