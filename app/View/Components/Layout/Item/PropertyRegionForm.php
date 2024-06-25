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
    public $url, $provinces,$method;
    public function __construct($url = null,$method='GET')
    {
        $provinces = Provinces::orderBy('name', 'asc')->get();
        $this->provinces = $provinces;
        $this->url = $url;
        $this->method = $method;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.property-region-form');
    }
}
