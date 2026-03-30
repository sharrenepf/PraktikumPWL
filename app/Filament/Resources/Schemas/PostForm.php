<?php

namespace App\Filament\Resources\Schemas;

use Filament\Forms\Form as Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([

                // ================= LEFT (2/3) =================
                Group::make()
                    ->columnSpan(2)
                    ->schema([

                        Section::make('Post Content')
                            ->description('Main content of the post')
                            ->icon('heroicon-o-pencil-square')
                            ->collapsible()
                            ->schema([

                                Grid::make(2)
                                    ->schema([

                                        TextInput::make('title')
                                            ->required()
                                            ->minLength(5)
                                            ->placeholder('Enter post title')
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, $set) =>
                                                $set('slug', preg_replace('/\s+/', '-', strtolower($state)))
                                            ),

                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->regex('/^(?=.*[0-9])(?=.*[_!*?@#$-]).+$/')
                                            ->validationMessages([
                                                'unique' => 'Slug must be unique',
                                                'regex'  => 'Slug harus mengandung angka & karakter spesial',
                                            ])
                                            ->placeholder('auto-generated-slug'),

                                        Select::make('category_id')
                                            ->label('Category')
                                            ->relationship('category', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                        ColorPicker::make('color')
                                            ->default('#000000')
                                            ->required(),

                                    ]),

                                MarkdownEditor::make('content')
                                    ->columnSpanFull()
                                    ->placeholder('Write your content here...')
                                    ->required(),

                            ]),
                    ]),

                // ================= RIGHT (1/3) =================
                Group::make()
                    ->columnSpan(1)
                    ->schema([

                        Section::make('Media')
                            ->icon('heroicon-o-photo')
                            ->collapsible()
                            ->schema([
                                FileUpload::make('image')
                                    ->image()
                                    ->required(fn ($context) => $context === 'create') // ✅ wajib saat create
                                    ->disk('public')
                                    ->directory('posts')
                                    ->visibility('public')
                                    ->imagePreviewHeight('150')
                                    ->loadingIndicatorPosition('left')
                                    ->panelAspectRatio('2:1')
                                    ->panelLayout('integrated')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                                    ->maxSize(2048)
                                    ->validationMessages([
                                        'required' => 'Gambar wajib diupload',
                                        'image' => 'File harus berupa gambar',
                                        'max' => 'Ukuran maksimal 2MB',
                                    ]),
                            ]),

                        Section::make('Publish')
                            ->icon('heroicon-o-megaphone')
                            ->collapsible()
                            ->schema([

                                Checkbox::make('is_published')
                                    ->label('Published'),

                                DateTimePicker::make('published_at')
                                    ->seconds(false),

                            ]),

                        Section::make('Tags')
                            ->icon('heroicon-o-tag')
                            ->collapsible()
                            ->schema([
                                TagsInput::make('tags')
                                    ->placeholder('Add tags'),
                            ]),
                    ]),
            ]);
    }
}