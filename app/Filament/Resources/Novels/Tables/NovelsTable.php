<?php

namespace App\Filament\Resources\Novels\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NovelsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        ImageColumn::make("cover")
          ->label("Cover")
          ->disk('public')
          ->height(50),
        TextColumn::make("title"),
        TextColumn::make('chapters_count')
          ->label('Chapters')
          ->sortable(),
        TextColumn::make("synopsis")
          ->limit(50),
        TextColumn::make("author"),
        TextColumn::make("rating")
          ->numeric(1)
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->recordActions([
        EditAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
