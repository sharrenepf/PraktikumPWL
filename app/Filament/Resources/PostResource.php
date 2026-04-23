<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// Import class konfigurasi tabel Anda
use App\Filament\Admin\Resources\Posts\Tables\PostsTable;
use App\Filament\Resources\Schemas\PostForm;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return PostForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        // Panggil class PostsTable agar perubahan di file tersebut langsung aktif
        return PostsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}