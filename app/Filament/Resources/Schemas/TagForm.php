<?php

namespace App\Filament\Admin\Resources\Tags\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Support\Str;

class TagForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required() // Mencegah field kosong sebelum dikirim ke DB
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, $set) => 
                        $operation === 'create' ? $set('slug', Str::slug($state)) : null
                    ),

                TextInput::make('slug')
                    ->required()
                    ->unique('tags', 'slug', ignoreRecord: true),
            ]);
    }
}