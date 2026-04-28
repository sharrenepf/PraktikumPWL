<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                // Tambahkan kolom ID sesuai jobsheet
                Tables\Columns\TextColumn::make('id')->label('ID'),

                // Tambahkan searchable pada kolom name
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
               Tables\Actions\CreateAction::make()->label('New tag'),
            Tables\Actions\AttachAction::make()->label('Attach'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tambahkan DetachAction (melepas relasi tanpa menghapus data tag)
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tambahkan aksi bulk detach dan delete sesuai jobsheet
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}