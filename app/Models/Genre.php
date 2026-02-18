<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Genre extends Model
{
  protected $fillable = ['name', 'slug'];

  public function novels()
  {
    return $this->belongsToMany(Novel::class)->withTimestamps();
  }

  protected static function booted()
  {
    static::saving(function (self $genre) {
      if (blank($genre->slug) && filled($genre->name)) {
        $genre->slug = static::generateUniqueSlug($genre->name, $genre->getKey());
      }
    });
  }

  protected static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
  {
    $baseSlug = Str::slug($name);

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
