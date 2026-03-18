<?php

namespace App\Filament\Admin\Resources\Categories\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug'),
            ])
            ->filters([
                //
            ])
            ->actions([ // Filament v3 biasanya menggunakan ->actions() bukan ->recordActions()
                EditAction::make(),
            ])
            ->bulkActions([ // Filament v3 biasanya menggunakan ->bulkActions() bukan ->toolbarActions()
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}