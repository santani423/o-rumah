<?php

namespace App\View\Components\Layout\Item;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductItem extends Component
{
    /**
     * Create a new component instance.
     */
    public $title, $image, $area, $address, $linkTujuan, $jk, $jkm, $lb, $lt, $content, $price,$type;

    public function __construct($title = "", $image = null, $area = '', $address = '', $linkTujuan = null, $jk = '', $jkm = '', $lb = '', $lt = '', $content = '', $price = 0,$type='property')
    {
        $this->title = $title;
        $this->price = "Rp " . number_format($price, 0, ',', '.');
        $this->area = $area;
        $this->address = $address;
        $this->linkTujuan = $linkTujuan;
        $this->image = $image ?? asset('zenter/horizontal/assets/images/small/img-2.jpg');
        $this->jk = $jk;
        $this->jkm = $jkm;
        $this->lb = $lb;
        $this->content = $content;
        $this->type = $type;
        $this->lt = $lt;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.product-item');
    }
}
