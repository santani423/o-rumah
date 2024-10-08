<?php

namespace App\View\Components\Layout\Item;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\AdsProperty;

class PropertyCategoryComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $propertyType,$ads;

    public function __construct($ads=null)
    {
        $this->ads = $ads;
        $this->propertyType = AdsProperty::getAllPropertyType();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.property-category-component');
    }
}
