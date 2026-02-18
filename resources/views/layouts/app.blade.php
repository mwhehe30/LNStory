<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', config('app.name', 'Novel App'))</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-zinc-900">
  <header class="sticky top-0 z-50 border-b border-zinc-200 bg-white/80 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4">
      <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight">
        {{ config('app.name', 'Novel App') }}
      </a>

      <nav class="flex items-center gap-4 text-sm text-zinc-600">
        <a href="{{ route('home') }}" class="transition-colors hover:text-black">Home</a>
        <a href="{{ route('novels.index') }}" class="transition-colors hover:text-black">Novels</a>
      </nav>
    </div>
  </header>

  <main class="mx-auto min-h-screen max-w-6xl px-4 py-8">
    @yield('content')
  </main>

  <footer class="border-t border-zinc-200">
    <div class="mx-auto max-w-6xl px-4 py-6 text-sm text-zinc-500">
      <span>{{ config('app.name', 'Novel App') }}</span>
    </div>
  </footer>
</body>

</html>
