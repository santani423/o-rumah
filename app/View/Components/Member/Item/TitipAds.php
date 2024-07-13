<?php

namespace App\View\Components\Member\Item;

use App\Models\Ads;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class TitipAds extends Component
{
    /**
     * Create a new component instance.
     */
    public $ads;
    public function __construct($ads='')
    {
      
        $this->ads = $ads;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.member.item.titip-ads');
    }
}
