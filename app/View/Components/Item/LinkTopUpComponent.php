<?php

namespace App\View\Components\Item;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class LinkTopUpComponent extends Component
{
    /**
     * Create a new component instance.
     */

     public $pln;
    public function __construct($planId="")
    {
        $plan = DB::table('plans')->where('id',$planId)->first();
        $this->pln  = $plan;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.item.link-top-up-component');
    }
}
