<?php

namespace App\View\Components\Layout\Item;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FoodDetails extends Component
{
    /**
     * Create a new component instance.
     */
    public $ads;
    public function __construct($ads = [])
    {
        $this->ads = $ads;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.food-details');
    }
}
