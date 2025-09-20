<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

use Illuminate\Support\Str;
use function Laravel\Prompts\select;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('thumbnail')
                    ->image()
                    ->directory('menus')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('name')
                    ->columnSpanFull()
                    ->debounce(100)
                    ->reactive()
                    ->afterStateUpdated(function($state, callable $set){
                        $set('slug', Str::slug($state));
                            })
                    ->required(),
                TextInput::make('slug')
                    ->readOnly()
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->required()
                    ->columnSpanFull()
                    ->relationship('category', 'name'),
                Repeater::make('menuOptionGroups')
                    ->relationship('menuOptionGroups') // relation from Menu model
                    ->schema([
                        Select::make('option_group_id')
                            ->relationship('optionGroup', 'name') // relation from pivot to OptionGroup model
                            ->required(),
                    ])
                    ->columns(1),
                TextInput::make('price')
                    ->required()
                    ->columnSpanFull()
                    ->numeric()
                    ->prefix('IDR')
                    ->reactive(),
                Toggle::make('is_promo')
                    ->columnSpanFull()
                    ->reactive(),
                Select::make('percent')
                    ->options([
                        10 => '10%',
                        15 => '15%',
                        20 => '20%',
                        25 => '25%',
                        30 => '30%',
                    ])
                    ->columnSpanFull()
                    ->reactive() // Reactive to trigger changes on other fields
                    ->hidden(fn($get) => !$get('is_promo'))
                    ->afterStateUpdated(function ($set, $get, $state) {
                        if ($get('is_promo') && $get('price') && $get('percent')) {
                            $discount = ($get('price') * (int)$get('percent')) / 100;
                            $set('price_after_discount', $get('price') - $discount);
                        } else {
                            $set('price_after_discount', $get('price'));
                        }
                    }), 
                TextInput::make('price_after_discount')
                    ->numeric()
                    ->prefix('IDR')
                    ->readOnly()
                    ->columnSpanFull()
                    ->hidden(fn($get) => !$get('is_promo')),
                // TextInput::make('sold_count')
                //     ->readOnly()
                //     ->numeric()
                //     ->default(0),
            ]);
    }
}
