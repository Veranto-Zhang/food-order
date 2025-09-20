<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('code')
                ->label('Order Code')
                ->searchable()
                ->sortable(),
        
            TextColumn::make('name')
                ->label('Customer')
                ->searchable(),
        
            TextColumn::make('table_no')
                ->label('Table')
                ->searchable()
                ->sortable(),
        
            // Payment Method Badge
            BadgeColumn::make('payment_method')
                ->label('Payment Method')
                ->sortable()
                ->colors([
                    'success' => 'online_payment',
                    'warning' => 'pay_at_cashier',
                ])
                ->formatStateUsing(fn ($state) => match ($state) {
                    'online_payment' => 'Online Payment',
                    'pay_at_cashier' => 'Pay at Cashier',
                    default => ucfirst($state),
                }),
        
            // Payment Status Badge
            TextColumn::make('payment_status')
                ->label('Payment Status')
                ->sortable(),
        
            // Order Status Badge
            BadgeColumn::make('order_status')
                ->label('Order Status')
                ->sortable()
                ->colors([
                    'warning' => 'pending',
                    'info'    => 'confirmed',
                    'primary' => 'processing',
                    'success' => 'completed',
                    'danger'  => 'canceled',
                ])
                ->formatStateUsing(fn ($state) => ucfirst($state)),
        
            TextColumn::make('transaction_date')
                ->label('Date')
                ->date()
                ->sortable(),
        
            TextColumn::make('total_amount')
                ->label('Total')
                ->numeric()
                ->prefix('IDR ')
                ->sortable(),
        
            TextColumn::make('deleted_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
