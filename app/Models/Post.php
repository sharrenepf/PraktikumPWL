<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Sesuaikan dengan kolom di database Anda.
     */
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'color',
        'image',
        'content', // Menggunakan 'content' sesuai migrasi terbaru
        'is_published',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     * Kolom 'tags' (array) dihapus karena sudah menggunakan tabel pivot.
     */
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'date',
    ];

    /**
     * Relasi ke Model Category (One-to-Many).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke Model Tag (Many-to-Many).
     * Menggunakan tabel pivot 'post_tag'.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
}