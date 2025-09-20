<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Order Tabs')
                    ->columnSpanFull()
                    ->tabs([

                        // === Overview Tab ===
                        Tab::make('Overview')
                            ->schema([

                                Section::make('Order Information')
                                    ->schema([
                                        TextInput::make('code')
                                            ->label('Order Code')
                                            ->disabled(),

                                        TextInput::make('transaction_date')
                                            ->label('Transaction Date')
                                            ->disabled(),

                                        TextInput::make('table_no')
                                            ->label('Table Number')
                                            ->disabled(),
                                    ])
                                    ->columns(3),

                                Section::make('Customer Information')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Customer Name')
                                            ->disabled(),

                                        TextInput::make('phone_number')
                                            ->label('Phone Number')
                                            ->disabled(),
                                    ])
                                    ->columns(2),

                                Section::make('Payment Information')
                                    ->schema([
                                        Select::make('payment_method')
                                            ->label('Payment Method')
                                            ->options([
                                                'online_payment' => 'Online Payment',
                                                'pay_at_cashier' => 'Pay at Cashier',
                                            ])
                                            ->disabled(),

                                        TextInput::make('total_amount')
                                            ->label('Total Amount')
                                            ->prefix('IDR')
                                            ->disabled(),
                                    ])
                                    ->columns(2),

                                Section::make('Status')
                                    ->schema([
                                        TextInput::make('payment_status')
                                            ->label('Payment Status'),
                                        Select::make('order_status')
                                            ->label('Order Status')
                                            ->options([
                                                'pending' => 'Pending',
                                                'processing' => 'Processing',
                                                'completed' => 'Completed',
                                                'canceled' => 'Canceled',
                                            ])
                                            ->required(),
                                    ])
                                    ->columns(2),
                            ]),

                        // === Order Items Tab ===
                        Tab::make('Order Items')
                            ->schema([
                                Repeater::make('orderItems')
                                    ->relationship('orderItems')
                                    ->disabled()
                                    ->label('Items')
                                    ->schema([
                                        Select::make('menu_id')
                                            ->relationship('menu', 'name')
                                            ->label('Menu')
                                            ->disabled(),

                                        TextInput::make('quantity')
                                            ->label('Quantity')
                                            ->disabled(),

                                        TextInput::make('price')
                                            ->label('Price')
                                            ->prefix('IDR')
                                            ->disabled(),

                                        TextInput::make('subtotal')
                                            ->label('Subtotal')
                                            ->prefix('IDR')
                                            ->disabled(),

                                        Repeater::make('orderItemOptions')
                                            ->relationship('orderItemOptions')
                                            ->label('Order Item Options')
                                            ->disabled()
                                            ->schema([
                                                Select::make('option_value_id')
                                                    ->relationship('optionValue', 'name')
                                                    ->label('Option')
                                                    ->disabled(),

                                                TextInput::make('extra_price')
                                                    ->label('Extra Price')
                                                    ->prefix('IDR')
                                                    ->disabled(),
                                            ])
                                            ->columns(2),
                                    ])
                                    ->columns(2),
                            ]),
                    ]),
            ]);

    }
}
