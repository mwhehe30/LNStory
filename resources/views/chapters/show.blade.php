@extends('layouts.app')

@section('title', $novel->title . ' - Chapter ' . $chapter->chapter_number)

@section('content')
  <div class="mb-6">
    <a href="{{ route('novels.show', $novel) }}" class="text-sm text-zinc-500 hover:text-black inline-flex items-center transition-colors">
      <x-heroicon-o-chevron-left class="mr-2 h-4 w-4" /> Back to novel
    </a>
  </div>

  <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
    <div class="text-sm font-semibold text-zinc-500">{{ $novel->title }}</div>
    <h1 class="mt-2 text-2xl font-semibold text-zinc-900">Chapter {{ $chapter->chapter_number }}: {{ $chapter->title }}</h1>

    <div class="mt-6 whitespace-pre-line text-lg leading-relaxed text-zinc-800">
      {{ $chapter->content }}
    </div>
  </div>

  <div class="mt-6 flex items-center justify-between gap-4">
    <div>
      @if ($previous)
        <a
          class="inline-flex items-center rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-semibold hover:bg-zinc-50 transition-colors"
          href="{{ route('chapters.show', [$novel, $previous->chapter_number, $previous->slug]) }}"
        >
          <x-heroicon-o-chevron-left class="mr-2 h-4 w-4" /> Previous
        </a>
      @endif
    </div>

    <div>
      @if ($next)
        <a
          class="inline-flex items-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-black hover:bg-amber-400 transition-colors"
          href="{{ route('chapters.show', [$novel, $next->chapter_number, $next->slug]) }}"
        >
          Next <x-heroicon-o-chevron-right class="ml-2 h-4 w-4" />
        </a>
      @endif
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const novelId = {{ $novel->id }};
        const chapterNumber = {{ $chapter->chapter_number }};
        const storageKey = 'read_chapters';

        let readChapters = JSON.parse(localStorage.getItem(storageKey) || '[]');
        const entry = `novel_${novelId}_ch_${chapterNumber}`;

        if (!readChapters.includes(entry)) {
            readChapters.push(entry);
            localStorage.setItem(storageKey, JSON.stringify(readChapters));
        }
    });
  </script>
@endsection
