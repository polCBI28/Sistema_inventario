<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProveedorController extends Controller
{

    public function index()
    {
        return view('admin.proveedor.index');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ruc' => 'required',
            'razon_social' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required'

        ]);

        try {
            $validator->validate();

            Proveedor::create([
                'ruc' => $request->ruc,
                'razon_social' => $request->razon_social,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'email' => $request->email

            ]);
            return redirect()->route('admin.proveedor.index')
                ->with('success', 'El proveedor fue registrado correcto ');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'ruc' => 'required',
            'razon_social' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required'
        ]);

        try {
            
            $validator->validate();

            Proveedor::create([
                'ruc' => $request->ruc,
                'razon_social' => $request->razon_social,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'email' => $request->email

            ]);
            return redirect()->route('admin.proveedor.index')
                ->with('success', 'El proveedor fue actualizado correcto');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }


    public function destroy(string $id)
    {
        Proveedor::find($id)->delete();
        return redirect()->route('admin.proveedor.index')->with('success','La catogoria fue eliminado correctamente.');
    }
}
