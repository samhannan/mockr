<?php

namespace App\Models;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endpoint extends Model
{
    use HasFactory, SoftDeletes, Blameable;

    protected $fillable = [
        'url',
        'key',
        'method',
        'headers',
        'status_code',
        'delay',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
