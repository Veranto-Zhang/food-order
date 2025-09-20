<?php

namespace App\Filament\Resources\Tables\Pages;
use Filament\Notifications\Notification;

use App\Filament\Resources\Tables\TableResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTable extends CreateRecord
{
    protected static string $resource = TableResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record; // Newly created table
        $record->generateQr();   // Generate QR after save

        Notification::make()
            ->title('Table created and QR generated')
            ->success()
            ->send();
    }

}
