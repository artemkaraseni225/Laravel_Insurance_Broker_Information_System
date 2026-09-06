<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceType extends Model
{
    protected $fillable = ['name', 'code', 'description', 'status'];

    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
