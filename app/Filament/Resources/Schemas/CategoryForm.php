<?php

namespace App\Filament\Admin\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form; // Perhatikan: Filament v3 sering pakai Form, bukan Schema

class CategoryForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([ // Method utamanya biasanya bernama ->schema()
                TextInput::make('name')->required(),
                TextInput::make('slug')->required(),
            ]);
    }
}