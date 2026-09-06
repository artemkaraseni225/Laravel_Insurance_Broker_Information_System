<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['policy_id', 'amount', 'status', 'payment_method', 'paid_at'];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
        ];
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }
}
