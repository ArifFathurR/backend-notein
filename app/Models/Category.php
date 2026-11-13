<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'id_user',
    ];

        const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    // Category dimiliki oleh User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Category memiliki banyak Note
    public function notes(): HasMany
    {
        return $this->hasMany(Notes::class, 'id_category');
    }
}
