<?php

namespace App\Livewire\Admin;

use App\Models\Proveedor;
use Livewire\Component;
use Livewire\WithPagination;

class ProveedorTable extends Component
{
    use WithPagination;

    public function render()
    {
        $proveedores = Proveedor::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.admin.proveedor-table', compact('categorias'));
    }
}
