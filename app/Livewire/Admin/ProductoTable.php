<?php

namespace App\Livewire\Admin;

use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class ProductoTable extends Component
{
    use WithPagination;

    public function render()
    {
        $products = Producto::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.admin.producto-table', compact('products'));
    }
}