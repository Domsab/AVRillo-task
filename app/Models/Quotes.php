<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quotes extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote',
    ];
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
