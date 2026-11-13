<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class NotesTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'status',
        'id_notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    // Task dimiliki oleh Note
    public function note(): BelongsTo
    {
        return $this->belongsTo(Notes::class, 'id_notes');
    }
}
