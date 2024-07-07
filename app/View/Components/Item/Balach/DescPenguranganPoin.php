<?php

namespace App\View\Components\Item\Balach;

use App\Models\AdBalaceControl;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DescPenguranganPoin extends Component
{
    /**
     * Create a new component instance.
     */
    public $abc;
    public function __construct($code = '')
    {
        $abc = AdBalaceControl::where('code',$code)->first();
        $this->abc = $abc;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.item.balach.desc-pengurangan-poin');
    }
}
