<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Internship extends Model
{
    protected $fillable = [
        'user_id','status','letter_path','letter_uploaded_at','confirmed_at'
    ];

    protected $casts = [
        'letter_uploaded_at' => 'datetime',
        'confirmed_at'       => 'datetime',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
