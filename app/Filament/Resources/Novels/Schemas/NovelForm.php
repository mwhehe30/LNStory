<?php

namespace App\Filament\Resources\Novels\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NovelForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make("title")
          ->required()
          ->maxLength(255),
        Select::make('genres')
          ->relationship('genres', 'name')
          ->multiple()
          ->searchable()
          ->preload(),
        Textarea::make("synopsis")
          ->required()
          ->rows(10)
          ->columnSpan('full'),
        TextInput::make("author")
          ->required(),
        TextInput::make("rating")
          ->numeric()
          ->step(0.1)
          ->minValue(0)
          ->maxValue(10)
          ->default(0),
        FileUpload::make("cover")
          ->image()
          ->disk('public')
          ->directory('novel-covers')
          ->required()
      ]);
  }
}
