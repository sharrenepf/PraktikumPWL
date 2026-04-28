<?php

namespace App\Filament\Admin\Resources\Posts\Tables;

use App\Models\Post;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('color')
                    ->toggleable(), // Aktifkan fitur pilih kolom

                ImageColumn::make('image')
                    ->disk('public')
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload(),
            ])
            ->actions([
                ReplicateAction::make(),
                EditAction::make(),
                DeleteAction::make(),

                Action::make('status_change')
                    ->label(fn (Post $record): string => $record->is_published ? 'Unpublish' : 'Publish')
                    ->icon(fn (Post $record): string => $record->is_published ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (Post $record): string => $record->is_published ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->action(fn (Post $record) => $record->update(['is_published' => !$record->is_published])),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}