<?php

namespace App\View\Components\Tool;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Models\UserPropertyStatistics as Ups;
use App\Services\ToolService;

class UserPropertyStatistics extends Component
{
    use ToolService;
    public $userId;
    public $totalProperties;
    public $total_sold_properties;
    public $total_rented_properties;

    /**
     * Create a new component instance.
     *
     * @param int $userId
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
     
        $dataStatisProperti = $this->getPropertyAdStatistics($userId);

        // Retrieve the user's property statistics
        $stats = Ups::where('user_id', $userId)->first();

        $this->totalProperties = $dataStatisProperti['active_properties'];
        if ($stats) {
            $this->total_sold_properties = $stats->total_sold_properties;
            $this->total_rented_properties = $stats->total_rented_properties;
        } else {
            // $this->totalProperties = 0;
            $this->total_sold_properties = 0;
            $this->total_rented_properties = 0;
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
