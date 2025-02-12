<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'saas_product_name', 'start_date', 'end_date', 'price'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
