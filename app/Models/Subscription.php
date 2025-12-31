<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan',
        'status',
        'starts_at',
        'ends_at',
        'payment_reference',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    // 🔗 RELATION
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ STATUS CHECK
    public function isActive(): bool
    {
        return $this->status === 'active'
            && now()->between($this->starts_at, $this->ends_at);
    }
}
