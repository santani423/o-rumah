<?php

namespace App\View\Components\Layout\Item\Food\Edit;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class PropertyAdForm extends Component
{
    /**
     * Create a new component instance.
     */
    public $ads;
    public function __construct($ads=[])
    {
        $this->ads = $ads;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.food.edit.property-ad-form');
    }
}
