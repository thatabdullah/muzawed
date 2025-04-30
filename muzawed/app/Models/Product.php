<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'name',
        'description_en',
        'description_ar',
        'category_id',
        'currency',
        'pricing_model',
        'active',
        'featured',
        'detailed_description_en',
        'detailed_description_ar',
        'key_features_en',
        'key_features_ar',
        'documentation_url',
        'version',
        'version_features_en',
        'version_features_ar',
        'average_rating',
        'review_count',
        'support_email',
        'support_hours',
        'product_link',
    ];

    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean',
        'average_rating' => 'decimal:2',
        'review_count' => 'integer',
        'key_features_en' => 'array',
        'version_features_en' => 'array',
        'key_features_ar' => 'array',
        'version_features_ar' => 'array',
        'detailed_description_en' => 'string',
        'description_en' => 'string',
        'detailed_description_ar' => 'string',
        'description_ar' => 'string',
        
    ];

    public function getLogoUrlAttribute()
    {
        $path = "products/{$this->id}/{$this->id}.png";
        return Storage::disk('s3')->exists($path)
            ? Storage::disk('s3')->url($path)
            : 'https://placehold.co/64x32/2563eb/1e40af/png?text=Logo';
    }


    // Product belongs to a SaaS Provider (Account)
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    // Product belongs to a Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product has many Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Product has many Tags (Many-to-Many)
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }
    public function usersWhoBookmarked()
{
        return $this->belongsToMany(User::class, 'bookmark_user', 'product_id', 'user_id')->withTimestamps();
}

    public function integrationPartners()
    {
        return $this->belongsToMany(IntegrationPartner::class, 'product_integration_partner'); // many-to-many with product
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }
}
