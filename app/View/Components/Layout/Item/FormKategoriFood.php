<?php

namespace App\View\Components\Layout\Item;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Kategori;

class FormKategoriFood extends Component
{
    /**
     * Create a new component instance.
     */
    public $kategori;
    public function __construct()
    {
        //
        $kategoris = Kategori::where('tipe', 'food')->get();
        $this->kategori = $kategoris;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.form-kategori-food');
    }
}
