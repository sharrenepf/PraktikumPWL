<?php

namespace App\Filament\Resources\Table;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                // KOLOM BARU: Created_at
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime() // Format tanggal & waktu
                    ->sortable(),
            ]);
    }
}