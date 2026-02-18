@extends('layouts.app')

@section('title', $novel->title)

@section('content')
  <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-12">
    <div class="lg:col-span-3">
      <div class="aspect-[3/4] overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-100">
        @if ($novel->cover)
          <img
            src="{{ asset('storage/' . $novel->cover) }}"
            alt="{{ $novel->title }}"
            class="h-full w-full object-cover"
          />
        @endif
      </div>
    </div>

    <div class="lg:col-span-9">
      <h1 class="text-3xl font-semibold tracking-tight">{{ $novel->title }}</h1>
      <div class="mt-2 flex items-center gap-3 text-sm text-zinc-500">
        <span>By {{ $novel->author }}</span>
        <span class="h-1 w-1 rounded-full bg-zinc-300"></span>
        <div class="flex items-center gap-1 font-medium text-amber-600">
          <x-heroicon-s-star class="size-4" />
          {{ number_format($novel->rating, 1) }}
        </div>
      </div>

      @if ($novel->genres->count() > 0)
        <div class="mt-3 flex flex-wrap gap-2">
          @foreach ($novel->genres as $genre)
            <a
              href="{{ route('novels.index', ['genre' => $genre->slug]) }}"
              class="rounded-full border border-zinc-200 bg-white px-3 py-1 text-xs text-zinc-700 hover:border-zinc-300 transition-colors"
            >{{ $genre->name }}</a>
          @endforeach
        </div>
      @endif

      <div class="mt-4 rounded-2xl border border-zinc-200 bg-zinc-50 p-5 text-zinc-700">
        <div class="text-sm font-semibold text-zinc-900">Synopsis</div>
        <div class="mt-2 whitespace-pre-line text-sm leading-relaxed">{{ $novel->synopsis }}</div>
      </div>

      <div class="mt-6">
        <div class="mb-3 flex items-center justify-between">
          <h2 class="text-lg font-semibold">Chapters</h2>
          @if ($chapters->count() > 0)
            <a
              href="{{ route('chapters.show', [$novel, $chapters->first()->chapter_number, $chapters->first()->slug]) }}"
              class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-black hover:bg-amber-400"
            >Start Reading</a>
          @endif
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white shadow-sm overflow-hidden">
          @forelse ($chapters as $chapter)
            <a
              href="{{ route('chapters.show', [$novel, $chapter->chapter_number, $chapter->slug]) }}"
              class="flex items-center justify-between gap-3 border-b border-zinc-100 px-5 py-4 hover:bg-zinc-50 transition-colors last:border-0"
              data-chapter="{{ $chapter->chapter_number }}"
            >
              <div class="min-w-0">
                <div class="chapter-title truncate text-sm font-semibold">Chapter {{ $chapter->chapter_number }}: {{ $chapter->title }}</div>
              </div>
              <div class="text-[10px] font-medium text-zinc-400 whitespace-nowrap">{{ $chapter->created_at->diffForHumans() }}</div>
            </a>
          @empty
            <div class="px-5 py-6 text-sm text-zinc-500">No published chapters yet.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const novelId = {{ $novel->id }};
        const storageKey = 'read_chapters';
        const readChapters = JSON.parse(localStorage.getItem(storageKey) || '[]');

        document.querySelectorAll('[data-chapter]').forEach(link => {
            const chapNum = link.getAttribute('data-chapter');
            const entry = `novel_${novelId}_ch_${chapNum}`;

            if (readChapters.includes(entry)) {
                const title = link.querySelector('.chapter-title');
                if (title) {
                    title.classList.remove('text-zinc-900'); // Ensure default is removed if present
                    title.classList.add('text-amber-600');
                }
            }
        });
    });
  </script>
@endsection
