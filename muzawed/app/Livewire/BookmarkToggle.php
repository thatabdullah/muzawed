<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class BookmarkToggle extends Component
{
    public $productId;
    public $isBookmarked = false;
    public $isAuthenticated;
    public $error = '';

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->isAuthenticated = Auth::check();
        if ($this->isAuthenticated) {
            $this->isBookmarked = Auth::user()->bookmarks()->where('product_id', $this->productId)->exists();
        }
    }

    public function toggleBookmark()
    {
        \Log::info('ToggleBookmark called: user ' . (Auth::check() ? Auth::id() : 'guest') . ', product ' . $this->productId . ', URL ' . url()->current());
        if (!$this->isAuthenticated) {
            \Log::info('Redirecting to login from URL: ' . url()->current());
            return redirect()->route('login', ['locale' => app()->getLocale()]);
        }

        $throttleKey = Str::lower(Auth::user()->email) . '|bookmark|' . $this->productId . '|' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $this->error = __('Too many bookmark attempts. Please try again in :seconds seconds.', ['seconds' => RateLimiter::availableIn($throttleKey)]);
            \Log::info('Rate limit hit: ' . $this->error);
            return;
        }

        $user = Auth::user();
        if ($this->isBookmarked) {
            $user->bookmarks()->detach($this->productId);
            $this->isBookmarked = false;
            \Log::info('Detached bookmark: user ' . $user->id . ', product ' . $this->productId);
        } else {
            $user->bookmarks()->attach($this->productId);
            $this->isBookmarked = true;
            \Log::info('Attached bookmark: user ' . $user->id . ', product ' . $this->productId);
        }

        RateLimiter::hit($throttleKey, 60); // 1 minute
        $this->error = '';
        $this->dispatch('bookmark-updated');
        \Log::info('Bookmark toggled: isBookmarked ' . ($this->isBookmarked ? 'true' : 'false'));
    }

    public function render()
    {
        return view('livewire.bookmark-toggle');
    }
}