<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UsuarioController extends Controller
{
    
    public function updateUserRole(Request $request, $id)
    {
        // Buscar al usuario por su id
        $usuario = User::findOrFail($id);
    
        // Actualizar rol y estado
        $usuario->idrol = $request->input('idrol');
        $usuario->state = $request->input('state');
        
        // Guardar los cambios
        $usuario->save();
    
        // Redirigir o retornar una respuesta, según sea necesario
        return redirect()->route('listauser')->with('success', 'Usuario actualizado correctamente');
    }

}
