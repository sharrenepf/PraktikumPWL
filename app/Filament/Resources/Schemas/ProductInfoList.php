<?php

namespace App\Filament\Resources\Schemas;

use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Support\Enums\FontWeight;

class ProductInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Product Details')
                    ->tabs([
                        Tab::make('Product Info')
                            ->icon('heroicon-m-information-circle') // Icon Informasi
                            ->schema([
                                TextEntry::make('name'),
                                TextEntry::make('sku'),
                                TextEntry::make('description'),
                            ]),
                        Tab::make('Product Price and Stock')
                            ->icon('heroicon-m-banknotes') // Icon Keuangan/Harga
                            ->schema([
                                TextEntry::make('price')->money('idr'),
                                TextEntry::make('stock'),
                            ]),
                        Tab::make('Media and status')
                            ->icon('heroicon-m-photo') // Icon Media
                            ->schema([
                                ImageEntry::make('image'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}