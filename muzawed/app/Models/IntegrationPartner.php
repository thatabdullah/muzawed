<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class IntegrationPartner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'website'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_integration_partner');
    }
}
