<?php

namespace App\Filament\Resources\OptionValues\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OptionValueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('option_group_id')
                    ->required()
                    ->columnSpanFull()
                    ->relationship('optionGroup', 'name'),
                TextInput::make('name')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('extra_price')
                    ->required()
                    ->columnSpanFull()
                    ->numeric()
                    ->prefix('IDR')
                    ->default(0),
            ]);
    }
}
