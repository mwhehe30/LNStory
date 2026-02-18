<?php

namespace App\Filament\Resources\Chapters\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ChapterForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Select::make('novel_id')
          ->relationship('novel', 'title')
          ->searchable()
          ->preload()
          ->required(),

        TextInput::make('chapter_number')
          ->label('Chapter Number')
          ->numeric()
          ->required(),

        TextInput::make('title')
          ->required()
          ->maxLength(255),

        Textarea::make('content')
          ->required()
          ->rows(18)
          ->columnSpan('full'),

        Toggle::make('is_published')
          ->required(),
      ]);
  }
}
