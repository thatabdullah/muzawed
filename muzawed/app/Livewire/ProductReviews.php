<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use App\Models\Product;

class ProductReviews extends Component
{
    public $product;
    public $rating = 0;
    public $comment = '';
    public $hoverRating = 0;


    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:500'
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function setHoverRating($rating)
    {
        $this->hoverRating = $rating;
    }

    public function submitReview()
    {
        $this->validate();

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $this->product->id,
            'rating' => $this->rating,
            'comment' => $this->comment
        ]);

        $this->reset(['rating', 'comment', 'hoverRating']);
        $this->dispatch('review-added');
    }
    public function getRatingDistributionProperty()
{
    $totalReviews = $this->product->reviews()->count();
    
    if ($totalReviews === 0) {
        return [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0
        ];
    }

    $distribution = [];
    for ($i = 5; $i >= 1; $i--) {
        $count = $this->product->reviews()->where('rating', $i)->count();
        $distribution[$i] = round(($count / $totalReviews) * 100);
    }

    return $distribution;
}

    public function render()
    {
        $reviews = Review::with('user')
            ->where('product_id', $this->product->id)
            ->latest()
            ->paginate(5);

            return view('livewire.product-reviews', [
                'reviews' => $reviews,
                'averageRating' => $this->product->averageRating(),
                'totalReviews' => $this->product->reviews()->count(),
                'ratingDistribution' => $this->ratingDistribution 
            ]);
        }
    }