<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Internship extends Model
{
    protected $fillable = [
        'user_id','status',
        'letter_path','letter_uploaded_at',
        'confirmed_at','approved_by','approval_letter_path',
        'full_name','whatsapp','school','major','student_id','address',
        'start_date','end_date','profile_completed_at',
        'final_report_path','final_report_uploaded_at','completed_at',
    ];

    protected $casts = [
        'letter_uploaded_at'       => 'datetime',
        'confirmed_at'             => 'datetime',
        'start_date'               => 'date',
        'end_date'                 => 'date',
        'profile_completed_at'     => 'datetime',
        'final_report_uploaded_at' => 'datetime',
        'completed_at'             => 'datetime',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function approver(): BelongsTo { return $this->belongsTo(User::class, 'approved_by'); }
    public function messages() { return $this->hasMany(Message::class)->latest(); }

    // boleh upload laporan dalam 10 hari setelah end_date
    public function canUploadReport(): bool
    {
        if (!$this->end_date) return false;
        $deadline = $this->end_date->copy()->addDays(10);
        return now()->between($this->end_date, $deadline);
    }
}
