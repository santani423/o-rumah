<?php

namespace App\View\Components\Item;

use App\Models\PropertyType;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class PropertySearchBar extends Component
{
    /**
     * Create a new component instance.
     */
    public $tipeProperti;
    public function __construct()
    {
        $tipeProperti = PropertyType::orderBy('name','asc')->get();
        $this->tipeProperti = $tipeProperti;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.item.property-search-bar');
    }
}
