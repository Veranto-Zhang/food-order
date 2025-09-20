<?php

namespace App\Filament\Resources\OptionGroups\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OptionGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->columnSpanFull()
                    ->required(),
                Toggle::make('is_required')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('max_select')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
