<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
  public function show(Request $request, Novel $novel, int $chapter_number, ?string $slug)
  {
    $chapter = $novel->chapters()
      ->where('chapter_number', $chapter_number)
      ->where('is_published', true)
      ->firstOrFail();

    $previous = $novel->chapters()
      ->where('is_published', true)
      ->where('chapter_number', '<', $chapter->chapter_number)
      ->orderByDesc('chapter_number')
      ->first();

    $next = $novel->chapters()
      ->where('is_published', true)
      ->where('chapter_number', '>', $chapter->chapter_number)
      ->orderBy('chapter_number')
      ->first();

    return view('chapters.show', compact('novel', 'chapter', 'previous', 'next'));

  }
}
