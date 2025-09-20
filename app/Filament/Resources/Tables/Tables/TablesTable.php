<?php

namespace App\Filament\Resources\Tables\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class TablesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->sortable(),
                ImageColumn::make('image')
                    ->disk('public')
                    ->square(),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('download')
                    ->label('Download QR Code')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                            $filePath = storage_path('app/public/' . $record->image);
                            if (file_exists($filePath)) {
                                return response()->download($filePath);
                            }
                            session()->flash('error', 'QR code image not found.');
                        }),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
