<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  // ID of the user who wrote the review
        'product_id',  // ID of the product being reviewed
        'rating',  // Review rating (1-5)
        'comment',  // Review text
    ];

    protected $casts = [
        'created_at' => 'datetime', // Converts the timestamp to a DateTime object
    ];

    // A Review belongs to a User (the reviewer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A Review belongs to a Product (the reviewed product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
