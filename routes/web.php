<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NovelController;
use App\Http\Controllers\ChapterController;

Route::get('/', [NovelController::class, 'home'])->name('home');

Route::get('/novels', [NovelController::class, 'index'])->name('novels.index');

Route::get('/novels/{novel:slug}', [NovelController::class, 'show'])->name('novels.show');

Route::get('/novels/{novel:slug}/chapters/{number}-{slug?}', [ChapterController::class, 'show'])
  ->whereNumber('number')->name('chapters.show');
