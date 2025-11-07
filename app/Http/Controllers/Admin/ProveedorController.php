<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        } catch (ValidatorException $e) {
            return back()->withErrors($e->validator->error())->withInput();
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
        } catch (ValidatorException $e) {
            return back()->withErrors($e->validator->error())->withInput();
        }
    }


    public function destroy(string $id)
    {
        Proveedor::find($id)->dalete();
        return redirect()->route('admin.proveedor.index')->with('success','La catogoria fue eliminado correctamente.');
    }
}
