<?php

namespace App\Filament\Resources\Promocodes\Schemas;

use Filament\Forms\Get;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PromocodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                Select::make('discount_type')
                    ->options(['fixed' => 'Fixed', 'percent' => 'Percent'])
                    ->required(),
                TextInput::make('discount_value')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('expires_at'),
                TextInput::make('usage_limit')
                    ->numeric(),
                TextInput::make('times_used')
                    ->disabled()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
