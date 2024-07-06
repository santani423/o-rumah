<?php

namespace App\View\Components\Layout\Item;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserProfileCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $user,$content,$dataTarget;
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
