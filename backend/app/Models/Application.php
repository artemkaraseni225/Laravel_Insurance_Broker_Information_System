<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'customer_id',
        'broker_id',
        'insurance_type_id',
        'tariff_id',
        'status',
        'calculated_price',
        'insurance_data',
    ];

    protected function casts(): array
    {
        return [
            'insurance_data' => 'array',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function broker()
    {
        return $this->belongsTo(Broker::class);
    }

    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function policy()
    {
        return $this->hasOne(Policy::class);
    }
}
