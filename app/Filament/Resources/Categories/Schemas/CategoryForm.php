<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->image()
                    ->directory('categories')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('name')
                    ->reactive()
                    ->debounce(300)
                    ->afterStateUpdated(function ($state, callable $set){
                        $set('slug', Str::slug($state));
                    })
                    ->required(),
                TextInput::make('slug')
                    ->readOnly()
                    ->required(),
            ]);
    }
}
