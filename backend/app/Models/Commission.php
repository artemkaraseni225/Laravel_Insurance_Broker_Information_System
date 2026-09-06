<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = ['policy_id', 'broker_id', 'rate', 'amount', 'status', 'paid_at'];

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

    public function broker()
    {
        return $this->belongsTo(Broker::class);
    }
}
