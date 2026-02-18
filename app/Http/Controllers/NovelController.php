<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NovelController extends Controller
{
  //
  public function home(): View
  {
    $latestNovels = Novel::query()->with(['genres', 'latestChapter'])->latest()->take(10)->get();

    return view('home', compact('latestNovels'));
  }

  public function index(Request $request)
  {
    $search = (string) $request->string('q');
    $genreSlug = (string) $request->string('genre');

    $genres = Genre::query()->orderBy('name')->get();

    $novels = Novel::query()->with('genres')
      ->when($search !== '', function ($query) use ($search) {
        $query->where('title', 'like', "%{$search}%")->orWhere('synopsis', 'like', "%{$search}%");
      })
      ->when($genreSlug !== '', function ($query) use ($genreSlug) {
        $query->whereHas('genres', function ($query) use ($genreSlug) {
          $query->where('slug', $genreSlug);
        });
      })
      ->latest()
      ->paginate(12)
      ->withQueryString();

    return view('novels.index', compact('novels', 'search', 'genres', 'genreSlug'));

  }

  public function show(Novel $novel)
  {
    $novel->load('genres');

    $chapters = $novel->chapters()
      ->where('is_published', true)
      ->orderBy('chapter_number')
      ->get();

    return view('novels.show', compact('novel', 'chapters'));
  }
}
