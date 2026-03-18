<?php

namespace App\Filament\Resources\Schemas;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;

class UserForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true) // VALIDASI: Email harus unik
                    ->maxLength(255),

                TextInput::make('password')
                    ->password()
                    ->required(fn ($context) => $context === 'create')
                    ->minLength(6) // VALIDASI: Minimal 6 karakter
                    ->maxLength(255),
            ]);
    }
}