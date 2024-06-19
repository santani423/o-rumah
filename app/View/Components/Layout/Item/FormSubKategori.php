<?php

namespace App\View\Components\Layout\Item;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\SupKategori;

class FormSubKategori extends Component
{
    /**
     * Create a new component instance.
     */
    public $subKategori;
    public function __construct($kategori = '')
    {
        // dd($kategori);
        $this->subKategori = SupKategori::where('kategori_id', $kategori->id)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.item.form-sub-kategori');
    }
}
