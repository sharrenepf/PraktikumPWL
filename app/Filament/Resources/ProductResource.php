<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
// Import kedua Schema (Form dan Table)
use App\Filament\Resources\Schemas\ProductForm;
use App\Filament\Resources\Table\ProductTable;
use App\Filament\Resources\Schemas\ProductInfolist;
use Filament\Infolists\Infolist;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return ProductForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        // Pastikan namespace dan class ProductTable sudah benar di sistem Anda
        return ProductTable::configure($table);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        // Method ini mendaftarkan skema Infolist agar terbaca oleh Filament
        return ProductInfolist::configure($infolist);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}