<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = ['insurance_type_id', 'company_id', 'name', 'description', 'base_price', 'status'];

    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class);
    }

    public function company()
    {
        return $this->belongsTo(InsuranceCompany::class, 'company_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
