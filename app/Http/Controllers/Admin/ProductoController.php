<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductoController extends Controller
{
    /**
     * Mostrar listado de productos
     */
    public function index()
    {
        $productos = Producto::with(['categoria', 'proveedors'])->latest()->paginate(15);
        return view('admin.producto.index', compact('productos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $categorias  = Categoria::orderBy('nombre')->get();
        $proveedors = Proveedor::orderBy('nombre')->get();

        return view('admin.producto.create', compact('categorias', 'proveedors'));
    }

    /**
     * Guardar nuevo producto
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'          => 'required|unique:productos,nombre',
            'decripcion'      => 'nullable',
            'codigo_barras'  => 'nullable|unique:productos,codigo_barras',
            'precio_compra'   => 'required|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'stock_minimo'    => 'required|integer|min:0',
            'estado'          => 'required|boolean',
            'categoria_id'    => 'required',
            'proveedor_id'    => 'required',
        ], [
            'nombre.unique'         => 'Ya existe un producto con ese nombre.',
            'codigo_barras.unique'  => 'El código de barras ya está registrado.',
            'categoria_id.exists'   => 'La categoría seleccionada no es válida.',
            'proveedor_id.exists'   => 'El proveedor seleccionado no es válido.',
        ]);

        try {
            $validator->validate();

            Producto::create($request->only([
                'nombre',
                'decripcion',
                'codigo_barras',
                'precio_compra',
                'stock',
                'stock_minimo',
                'estado',
                'categoria_id',
                'proveedor_id'
            ]));

            return redirect()->route('admin.productos.index')
                ->with('success', 'Producto creado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(string $id)
    {
        $producto    = Producto::findOrFail($id);
        $categorias  = Categoria::orderBy('nombre')->get();
        $proveedors = Proveedor::orderBy('nombre')->get();

        return view('admin.producto.edit', compact('producto', 'categorias', 'proveedors'));
    }

    /**
     * Actualizar producto
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre'          => 'required|unique:productos,nombre,' . $producto->id,
            'decripcion'      => 'nullable',
            'codigo_barras'  => 'nullable|unique:productos,codigo_barras,' . $producto->id,
            'precio_compra'   => 'required',
            'stock'           => 'required',
            'stock_minimo'    => 'required',
            'estado'          => 'required|boolean',
            'categoria_id'    => 'required|exists:categorias,id',
            'proveedor_id'    => 'required|exists:proveedores,id',
        ], [
            'nombre.unique'        => 'Ya existe otro producto con ese nombre.',
            'codigo_barras.unique' => 'El código de barras ya está en uso por otro producto.',
        ]);

        try {
            $validator->validate();

            $producto->update($request->only([
                'nombre',
                'decripcion',
                'codigo_barras',
                'precio_compra',
                'stock',
                'stock_minimo',
                'estado',
                'categoria_id',
                'proveedor_id'
            ]));

            return redirect()->route('admin.productos.index')
                ->with('success', 'Producto actualizado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }
    }

    /**
     * Eliminar producto
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}