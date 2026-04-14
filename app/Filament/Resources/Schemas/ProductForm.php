<?php

namespace App\Filament\Resources\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Actions\Action;

class ProductForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Product Info')
                        ->icon('heroicon-m-information-circle')
                        ->description('Isi Informasi Produk')
                        ->schema([
                            Group::make([
                                TextInput::make('name')->required(),
                                TextInput::make('sku')->required(),
                            ])->columns(2),
                            MarkdownEditor::make('description'),
                        ]),

                    Step::make('Product Price and Stock')
                        ->icon('heroicon-m-currency-dollar')
                        ->description('Isi Harga dan Stok')
                        ->schema([
                            Group::make([
                                TextInput::make('price')
                                    ->numeric()
                                    ->required()
                                    ->prefix('IDR')
                                    ->minValue(1),
                                TextInput::make('stock')
                                    ->numeric()
                                    ->required(),
                            ])->columns(2),
                        ]),

                    Step::make('Media and status')
                        ->icon('heroicon-m-photo')
                        ->description('Isi Gambar Produk')
                        ->schema([
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('products'),
                            Checkbox::make('is_active')
                                ->default(true),
                            Checkbox::make('is_featured')
                                ->default(false),
                        ]),
                ])
                ->columnSpanFull()
                // Action ini mencegah error SQLSTATE 1364 dengan memastikan state terkirim
                ->submitAction(
                    Action::make('save')
                        ->label('Save Product')
                        ->button()
                        ->color('primary')
                        ->submit('save')
                )
            ]);
    }
}