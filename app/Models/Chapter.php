<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Chapter extends Model
{
  protected $fillable = [
    'novel_id',
    'chapter_number',
    'title',
    'slug',
    'content',
    'is_published',
  ];

  public function novel()
  {
    return $this->belongsTo(Novel::class);
  }

  protected static function booted()
  {
    static::saving(function (self $chapter): void {
      if (blank($chapter->slug) && filled($chapter->title)) {
        $chapter->slug = static::generateUniqueSlug(
          $chapter->novel_id,
          $chapter->title,
          $chapter->getKey()
        );
      }
    });
  }

  protected static function generateUniqueSlug(int $novelId, string $title, ?int $ignoreId = null)
  {
    $baseSlug = Str::slug($title);

    $slug = $baseSlug;
    $suffix = 2;

    while (
      static::query()
        ->where('novel_id', $novelId)
        ->when($ignoreId, fn($query) => $query->whereKeyNot($ignoreId))
        ->where('slug', $slug)
        ->exists()
    ) {
      $slug = $baseSlug . '-' . $suffix;
      $suffix++;
    }

    return $slug;
  }
}
