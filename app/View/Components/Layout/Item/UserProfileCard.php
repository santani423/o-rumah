<?php

namespace App\View\Components\Layout\Item;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\ToolService;

class UserProfileCard extends Component
{
    
    use ToolService;
    /**
     * Create a new component instance.
     */
    public $user,$content,$dataTarget,$dataStatisProperti;
    public function __construct($user='',$content='',$dataTarget='userDetailModal')
    {
        
        $this->user = $user;
        $this->dataTarget = $dataTarget;
        $this->content = $content; 
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.user-profile-card');
    }
}
