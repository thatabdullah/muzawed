<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\Review; 

class ProfilePage extends Component
{
    public $name;
    public $email;
    public $status = '';
    public $bookmarkedProducts;
    public $userReviews;

    protected $listeners = ['bookmark-updated' => 'refreshBookmarks', 'review-deleted' => 'refreshReviews'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,{id}',
    ];

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->refreshBookmarks();
        $this->refreshReviews();

    }

    public function refreshBookmarks()
    {
        $bookmarks = Auth::user()->bookmarks()->orderByPivot('created_at', 'desc')->get();
        \Log::info('Bookmarks for user ' . Auth::id() . ': ' . $bookmarks->toJson());
        $this->bookmarkedProducts = $bookmarks;
    }
    public function refreshReviews()
    {
        $this->userReviews = Auth::user()->reviews()
            ->with('product') 
            ->latest()
            ->get();
    }
    public function deleteReview($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        
       
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();
        $this->dispatch('review-deleted');
        $this->status = __('Review deleted successfully.');
    }

    public function updateProfile()
    {
        $this->validate(['email' => 'required|email|unique:users,email,' . Auth::id()]);

        $throttleKey = Str::lower($this->email) . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $this->addError('email', __('Too many update attempts. Please try again in :seconds seconds.', ['seconds' => RateLimiter::availableIn($throttleKey)]));
            return;
        }

        Auth::user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        RateLimiter::clear($throttleKey);
        $this->status = __('Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.profile-page');
    }
}