<?php

namespace App\View\Components\Layout\Item;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\AdsProperty;

class PropertyDetailsForm extends Component
{
    /**
     * Create a new component instance.
     */
    public $certificate;
    public $house_facility;
    public $ads;
    public function __construct($ads=null)
    {
        // dd($ads);
         $this->ads = $ads;
        $this->certificate = AdsProperty::getAllCertificates();
        $this->house_facility = AdsProperty::getAllHouseFacility();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.property-details-form');
    }
}
