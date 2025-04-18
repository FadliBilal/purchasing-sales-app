<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name_customer', 
        'phone', 
        'address'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}