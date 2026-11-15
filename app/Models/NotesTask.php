<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class NotesTask extends Model
{
    use HasFactory;
    protected $table = 'notes_task';

    protected $fillable = [
        'task_name',
        'status',
        'notes_id',
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
        return $this->belongsTo(Notes::class, 'notes_id');
    }
}
