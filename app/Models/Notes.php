<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notes extends Model
{
    use HasFactory;

    protected $table = 'notes';

    protected $fillable = [
        'title',
        'description',
        'background_path',
        'status',
        'id_categories',
        'id_user',
    ];

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

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
        return $this->belongsTo(Category::class, 'id_categories');
    }

    // Note memiliki banyak Task
    public function tasks(): HasMany
    {
        return $this->hasMany(NotesTask::class, 'notes_id');
    }
}
