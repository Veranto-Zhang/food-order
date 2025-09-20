<?php

namespace App\Filament\Resources\Promocodes;

use App\Filament\Resources\Promocodes\Pages\CreatePromocode;
use App\Filament\Resources\Promocodes\Pages\EditPromocode;
use App\Filament\Resources\Promocodes\Pages\ListPromocodes;
use App\Filament\Resources\Promocodes\Pages\ViewPromocode;
use App\Filament\Resources\Promocodes\Schemas\PromocodeForm;
use App\Filament\Resources\Promocodes\Schemas\PromocodeInfolist;
use App\Filament\Resources\Promocodes\Tables\PromocodesTable;
use App\Models\Promocode;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromocodeResource extends Resource
{
    protected static ?string $model = Promocode::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPercentBadge;

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return PromocodeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PromocodeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PromocodesTable::configure($table);
    }

    public static function getModelLabel(): string
    {
        return 'Promo Code';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Promo Codes';
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPromocodes::route('/'),
            'create' => CreatePromocode::route('/create'),
            'view' => ViewPromocode::route('/{record}'),
            'edit' => EditPromocode::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
