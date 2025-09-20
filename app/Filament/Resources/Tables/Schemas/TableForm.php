<?php

namespace App\Filament\Resources\Tables\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TableForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('number')
                    ->label('Table Number')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10),
                FileUpload::make('image')
                    ->label('QR Code')
                    ->image()
                    ->disk('public')
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('QR code generated automatically.'),
            ]);
    }
}
