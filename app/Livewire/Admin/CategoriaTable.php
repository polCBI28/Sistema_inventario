<?php

namespace App\Livewire\Admin;

use App\Models\Categoria;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductoTable extends Component
{
    use WithPagination;

    public function render()
    {
        $products = Categoria::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.admin.categoria-table', compact('categoria'));
    }
}