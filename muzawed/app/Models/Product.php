<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'name',
        'description',
        'category_id',
        'currency',
        'discount_percentage',
        'pricing_model',
        'trial_period_days',
        'active',
        'featured',
        'detailed_description',
        'key_features',
        'documentation_url',
        'video_url',
        'main_image',
        'media_gallery',
        'version',
        'version_features',
        'average_rating',
        'review_count',
        'support_email',
        'live_chat_available',
        'support_hours',
        'renewal_period_days',
        'expiry_date',
    ];

    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean',
        'live_chat_available' => 'boolean',
        'media_gallery' => 'array',
        'integration_partners' => 'array',
        
    ];

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
        return $this->belongsToMany(User::class, 'bookmark_user');
}

    public function integrationPartners()
    {
        return $this->belongsToMany(IntegrationPartner::class, 'product_integration_partner'); // many-to-many with product
    }
}
