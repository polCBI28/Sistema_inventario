<?php

namespace App\Livewire\Admin;

use App\Models\Categoria;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriaTable extends Component
{
    use WithPagination;

    public function render()
    {
        $categorias = Categoria::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.admin.categoria-table', compact('categorias'));
    }
}