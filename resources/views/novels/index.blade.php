@extends('layouts.app')

@section('title', 'Novels')

@section('content')
  <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
      <h1 class="text-2xl font-semibold">Novels</h1>
      <p class="mt-1 text-sm text-zinc-500">Browse and read chapters.</p>
    </div>

    <form method="GET" action="{{ route('novels.index') }}" class="flex w-full gap-2 sm:w-auto">
      @if ($genreSlug !== '')
        <input type="hidden" name="genre" value="{{ $genreSlug }}" />
      @endif
      <input name="q" value="{{ $search }}" placeholder="Search title / synopsis"
        class="w-full rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm outline-none ring-0 placeholder:text-zinc-400 focus:border-zinc-300" />
      <button
        class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-black hover:bg-amber-400">Search</button>
    </form>
  </div>

  <div class="mb-6 flex flex-wrap items-center gap-2">
    <a href="{{ route('novels.index', array_filter(['q' => $search])) }}"
      class="{{ $genreSlug === '' ? 'border-amber-500 bg-amber-500 text-black' : 'border-zinc-200 bg-white text-zinc-700 hover:border-zinc-300' }} rounded-full border px-3 py-1 text-sm">All</a>

    @foreach ($genres as $genre)
      <a href="{{ route('novels.index', array_filter(['genre' => $genre->slug, 'q' => $search])) }}"
        class="{{ $genreSlug === $genre->slug ? 'border-amber-500 bg-amber-500 text-black' : 'border-zinc-200 bg-white text-zinc-700 hover:border-zinc-300' }} rounded-full border px-3 py-1 text-sm">{{ $genre->name }}</a>
    @endforeach
  </div>

  <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
    @forelse ($novels as $novel)
      <a href="{{ route('novels.show', $novel) }}"
        class="group relative flex flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white transition duration-300 hover:-translate-y-1 hover:border-zinc-300 hover:shadow-2xl hover:shadow-amber-500/5">
        <div class="aspect-[2/3] w-full overflow-hidden bg-zinc-100">
          @if ($novel->cover)
            <img src="{{ asset('storage/' . $novel->cover) }}" alt="{{ $novel->title }}"
              class="h-full w-full object-cover transition duration-500 group-hover:scale-110" />
          @else
            <div class="flex h-full w-full items-center justify-center text-zinc-700">
              <span class="text-4xl font-bold opacity-20">?</span>
            </div>
          @endif

          <div class="absolute inset-x-0 top-0 flex justify-end p-3">
            <div
              class="flex items-center gap-1 rounded-full bg-black/60 px-2 py-1 text-[10px] font-bold text-amber-400 backdrop-blur-md">
              <x-heroicon-s-star class="size-3" />
              {{ number_format($novel->rating, 1) }}
            </div>
          </div>

          <div
            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/0 to-black/0 opacity-60 transition duration-300 group-hover:opacity-80">
          </div>

          <div class="absolute bottom-0 left-0 right-0 p-4">
            <div class="mb-2 flex flex-wrap gap-1">
              @foreach ($novel->genres->take(2) as $genre)
                <span
                  class="rounded bg-black/60 px-1.5 py-0.5 text-[10px] font-medium text-white backdrop-blur-md">{{ $genre->name }}</span>
              @endforeach
              @if ($novel->genres->count() > 2)
                <span
                  class="rounded bg-black/60 px-1.5 py-0.5 text-[10px] font-medium text-white backdrop-blur-md">+{{ $novel->genres->count() - 2 }}</span>
              @endif
            </div>
            <h3
              class="line-clamp-2 text-lg font-bold leading-tight text-white transition-colors group-hover:text-amber-400">
              {{ $novel->title }}</h3>
            <p class="mt-1 line-clamp-1 text-xs font-medium text-zinc-300">by {{ $novel->author }}</p>
          </div>
        </div>
      </a>
    @empty
      <div
        class="col-span-full rounded-2xl border border-dashed border-zinc-200 bg-zinc-50 p-12 text-center text-zinc-500">
        <div class="mx-auto mb-3 h-12 w-12 text-zinc-300">
          <x-heroicon-o-book-open class="size-12" />
        </div>
        <p>No novels found matching your criteria.</p>
        @if ($search || $genreSlug)
          <a href="{{ route('novels.index') }}"
            class="mt-4 inline-block text-sm text-amber-500 hover:text-amber-400">Clear filters</a>
        @endif
      </div>
    @endforelse
  </div>

  <div class="mt-6">
    {{ $novels->links() }}
  </div>
@endsection
