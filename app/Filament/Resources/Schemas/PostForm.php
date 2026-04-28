<?php

namespace App\Filament\Resources\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                // Kolom Kiri: Detail Post (Lbar 2/3)
                Grid::make(2)
                    ->schema([
                        Section::make("Post Details")
                            ->description("Fill in the details of the post")
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->required()
                                    ->unique('posts', 'slug', ignoreRecord: true),

                                Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                ColorPicker::make('color'),

                                RichEditor::make('content')
                                    ->label('Content')
                                    ->columnSpanFull() // Agar editor melebar penuh di dalam section
                                    ->required(),
                            ])->columns(2),
                    ])->columnSpan(2),

                // Kolom Kanan: Meta & Media (Lebar 1/3)
                Grid::make(1)
                    ->schema([
                        Section::make("Image Upload")
                            ->schema([
                                FileUpload::make('image')
                                    ->image()
                                    ->directory('posts')
                                    ->required(),
                            ]),

                        Section::make("Meta Information")
                            ->schema([
                                // Multi-select Tags
                                Select::make('tags')
                                    ->label('Tags')
                                    ->multiple() // Memungkinkan pilih lebih dari satu
                                    ->relationship('tags', 'name') // Mengacu pada relasi BelongsToMany
                                    ->preload()
                                    ->searchable(),

                                Toggle::make('is_published')
                                    ->label('Published'),

                                DateTimePicker::make('published_at')
                                    ->label('Published At'),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3); // Layout utama 3 kolom
    }
}