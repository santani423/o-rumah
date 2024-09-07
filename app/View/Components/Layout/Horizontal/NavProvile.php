<?php

namespace App\View\Components\Layout\Horizontal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\LinkeAds;
use Illuminate\Support\Facades\Auth;

class NavProvile extends Component
{
    /**
     * Create a new component instance.
     */
    public $like,$unreadMessages;
    public function __construct()
    {
        $user = Auth::user();
        $this->like = LinkeAds::where('user_id', $user->id)->count();
        $this->unreadMessages  = 9;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.horizontal.nav-provile');
    }
}
