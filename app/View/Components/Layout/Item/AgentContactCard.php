<?php

namespace App\View\Components\Layout\Item;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AgentContactCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $agent, $btnKpr, $btnLelang, $ads;
    public function __construct($agent = [], $btnKpr = false, $btnLelang = false, $ads = null)
    {
        // dd($agent);
        $this->agent = $agent;
        $this->ads = $ads;
        $this->btnKpr = $btnKpr;
        $this->btnLelang = $btnLelang;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.agent-contact-card');
    }
}
