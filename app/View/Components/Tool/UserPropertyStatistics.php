<?php

namespace App\View\Components\Tool;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Models\UserPropertyStatistics as Ups;

class UserPropertyStatistics extends Component
{
    public $userId;
    public $totalProperties;
    public $soldRentedProperties;
    public $averagePrice;

    /**
     * Create a new component instance.
     *
     * @param int $userId
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;

        // Retrieve the user's property statistics
        $stats = Ups::where('user_id', $userId)->first();

        if ($stats) {
            $this->totalProperties = $stats->total_properties;
            $this->soldRentedProperties = $stats->sold_rented_properties;
            $this->averagePrice = $stats->average_price;
        } else {
            $this->totalProperties = 0;
            $this->soldRentedProperties = 0;
            $this->averagePrice = 0.00;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tool.user-property-statistics');
    }
}
