<?php

namespace App\View\Components\Layout\Horizontal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Master extends Component
{
    /**
     * Create a new component instance.
     */
    public $title, $body, $css, $js,$ogImage;
    public function __construct($title = '', $body = '', $css = '', $js = '',$ogImage='assets/logo-o-rumah-crop.png')
    {
        $this->title = $title;
        $this->body = $body;
        $this->css = $css;
        $this->js = $js;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.horizontal.master');
    }
}
