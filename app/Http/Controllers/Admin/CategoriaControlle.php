<?php

namespace App\Http\Controllers\Ardmin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\call;

class CategoriaControlle extends Controller
{
    public function index()
    {
        return view ('admin.categoria.index');
    }

  
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre' => 'required | string| max:255',
            'descripcion' => 'nullable|text',
            

        ]);

        try{
            $validator->validate();

            Categoria::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                
            ]);

            return redirect()->route('admin.categoria.index')
                ->with('success','La categoria fue registrado correctamente');
        }catch(ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

   
    public function update(Request $request, string $id)
    {
          $validator = Validator::make($request->all(),[
            'nombre' => 'required | string| max:255',
            'descripcion' => 'nullable|text',
            

        ]);

        try{
            $validator->validate();
        
            $categoria = Categoria::findOrFail($id);    
            Categoria::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                
            ]);

            return redirect()->route('admin.categoria.index')
                ->with('success','La categoria fue actualizado correctamente');
        }catch(ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy(string $id)
    {
        Categoria::find($id)->delete();
        return redirect() ->route('admin.categoria.index')->with('success','La categoria fu eliminada correctamente.');
    }
}
