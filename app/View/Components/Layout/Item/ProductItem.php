<?php

namespace App\View\Components\Layout\Item;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
class ProductItem extends Component
{
    /**
     * Create a new component instance.
     */
    public $title, $image, $area, $address, $linkTujuan, $jk, $jkm, $lb, $lt, $content, $price,$type,$label,$totalViews;

    public function __construct(
        $title = "", 
        $image = null, 
        $area = '', 
        $address = '', 
        $linkTujuan = null, 
        $jk = '', 
        $jkm = '', 
        $lb = '', 
        $lt = '', 
        $content = '', 
        $price = 0,
        $type='property',
        $label="",
        $labels="",
        $adsId=0)
    { 
        $totalViews = DB::table('advertising_points')->where('ads_id',$adsId)
        ->sum('advertising_points.views_count');
         
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
        $this->label = $label;
        $this->totalViews = $totalViews;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.product-item');
    }
}
