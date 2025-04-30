<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'saas_product_id', 'start_date', 'end_date', 'price'];
    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'saas_product_id');
    }

}
