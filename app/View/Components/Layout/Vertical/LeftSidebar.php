<?php

namespace App\View\Components\Layout\Vertical;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\AdBalance;

use Illuminate\Support\Facades\Auth;

class LeftSidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public $poin;
    public function __construct()
    {
        $poin = AdBalance::where('user_id', Auth::user()->id)->first();
        // dd(Auth::user());
        // dd(8);
        // $this->poin = Auth::user()->id;
        if (!$poin) {
            $poin = new AdBalance();
            $poin->user_id = Auth::user()->id;
            $poin->balance = 0;
            $poin->save();
        }
        $this->poin = $poin;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.vertical.left-sidebar');
    }
}
