<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Main Info')->schema([
                    // PILIH CATEGORY (RELASI)
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name')
                        ->required()
                        ->searchable()
                        ->preload(),

                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->readOnly()
                        ->unique(Product::class, 'slug', ignoreRecord: true),
                ])->columns(2),

                Forms\Components\Section::make('Details')->schema([
                    Forms\Components\RichEditor::make('description')->columnSpanFull(),
                    Forms\Components\TextInput::make('price')->numeric()->prefix('IDR')->required(),
                    Forms\Components\Toggle::make('is_active')->default(true),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')->label('Category')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->money('IDR')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}