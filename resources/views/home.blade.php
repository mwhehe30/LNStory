@extends('layouts.app')

@section('title', 'Welcome to ' . config('app.name', 'Novel App'))

@section('content')
  <div class="mb-12 text-center">
    <h1 class="text-4xl font-bold tracking-tight text-zinc-900 sm:text-5xl">Discover Your Next Favorite Story</h1>
    <p class="mt-4 text-lg text-zinc-600">Explore our collection of the latest and greatest novels.</p>
    <div class="mt-8">
      <a href="{{ route('novels.index') }}" class="inline-flex items-center gap-2 rounded-full bg-amber-500 px-8 py-3 text-sm font-semibold text-black hover:bg-amber-400 transition-colors shadow-lg shadow-amber-500/20">
        <x-heroicon-s-book-open class="size-5" />
        Browse All Novels
      </a>
    </div>
  </div>

  <div class="mb-8 flex items-center justify-between">
    <h2 class="text-2xl font-bold text-zinc-900 font-serif">Latest Updates</h2>
    <a href="{{ route('novels.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-amber-600 hover:text-amber-500">
      View All
      <x-heroicon-m-chevron-right class="size-4" />
    </a>
  </div>

  <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-5">
    @foreach ($latestNovels as $novel)
    <div>

      <a href="{{ route('novels.show', $novel) }}" class="group relative flex flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white transition duration-300 hover:-translate-y-1 hover:border-zinc-300 hover:shadow-2xl hover:shadow-amber-500/5">
        <div class="aspect-[2/3] w-full overflow-hidden bg-zinc-100">
          @if ($novel->cover)
          <img
          src="{{ asset('storage/' . $novel->cover) }}"
          alt="{{ $novel->title }}"
          class="h-full w-full object-cover transition duration-500 group-hover:scale-110"
          />
          @else
          <div class="flex h-full w-full items-center justify-center text-zinc-300">
            <span class="text-4xl font-bold opacity-20">?</span>
          </div>
          @endif

          <div class="absolute inset-x-0 top-0 flex justify-end p-2">
            <div class="flex items-center gap-1 rounded-full bg-black/60 px-2 py-1 text-[10px] font-bold text-amber-400 backdrop-blur-md">
              <x-heroicon-s-star class="size-3" />
              {{ number_format($novel->rating, 1) }}
            </div>
          </div>

          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-40 transition duration-300 group-hover:opacity-60"></div>

          <div class="absolute bottom-0 left-0 right-0 p-4">
            <h3 class="line-clamp-2 text-sm font-bold leading-tight text-white group-hover:text-amber-400 transition-colors">{{ $novel->title }}</h3>
          </div>
        </div>
      </a>
      @if ($novel->latestChapter)
      <a href="{{ route('chapters.show', [$novel, $novel->latestChapter->chapter_number, $novel->latestChapter->slug]) }}" class="mt-1 block bg-amber-500 w-full rounded-2xl py-2 px-4 transition hover:bg-amber-400">
        <div class="flex items-center justify-between gap-2">
            <span class="text-xs font-bold text-black text-nowrap">Chapter {{ $novel->latestChapter->chapter_number }}</span>
            <span class="text-[10px] font-medium text-black/60">{{ $novel->latestChapter->created_at->diffForHumans() }}</span>
        </div>
      </a>
      @endif
    </div>
      @endforeach
    </div>
    @endsection
