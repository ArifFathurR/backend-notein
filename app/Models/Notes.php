<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notes extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'background_path',
        'status',
        'id_category',
        'id_user',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    // Note dimiliki oleh User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Note dimiliki oleh Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    // Note memiliki banyak Task
    public function tasks(): HasMany
    {
        return $this->hasMany(NotesTask::class, 'id_notes');
    }
}
