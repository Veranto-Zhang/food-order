<?php

namespace App\Filament\Resources\Promocodes\Pages;

use App\Filament\Resources\Promocodes\PromocodeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPromocode extends ViewRecord
{
    protected static string $resource = PromocodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
