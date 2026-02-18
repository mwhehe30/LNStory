<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Novel extends Model
{
  protected $fillable = [
    'title',
    'slug',
    'author',
    'cover',
    'synopsis',
    'rating',
  ];

  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function chapters()
  {
    return $this->hasMany(Chapter::class);
  }

  public function latestChapter()
  {
    return $this->hasOne(Chapter::class)->where('is_published', true)->latestOfMany('chapter_number');
  }

  public function genres()
  {
    return $this->belongsToMany(Genre::class)->withTimestamps();
  }

  protected static function booted()
  {
    static::creating(function (self $novel): void {
      if (blank($novel->slug)) {
        $novel->slug = static::generateUniqueSlug($novel->title);
      }
    });

    static::updating(function (self $novel): void {
      if (
        (blank($novel->slug) || (!$novel->isDirty('slug') && $novel->isDirty('title')))
        && filled($novel->title)
      ) {
        $novel->slug = static::generateUniqueSlug($novel->title, $novel->getKey());
      }
    });
  }

  protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
  {
    $baseSlug = Str::slug($title);

    $slug = $baseSlug;
    $suffix = 2;

    while (
      static::query()
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
