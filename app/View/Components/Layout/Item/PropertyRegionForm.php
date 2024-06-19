<?php

namespace App\View\Components\Layout\Item;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Provinces;

class PropertyRegionForm extends Component
{
    /**
     * Create a new component instance.
     */
    public $url, $provinces;
    public function __construct($url = null)
    {
        $provinces = Provinces::orderBy('name', 'asc')->get();
        $this->provinces = $provinces;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.property-region-form');
    }
}
