<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Rol;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Llenar los campos validados en el modelo del usuario
        $user = $request->user();
        $user->fill($request->validated());

        // Verificar si el email ha cambiado
        if ($request->user()->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Guardar los cambios en la base de datos
        $user->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    const PAGINATION = 5;
    public function listauser(Request $request)
    {
        $roles = Rol::all()->where('id', '!=', 1);
        $buscarpor = $request->get('buscarpor');
        $usuarios = User::where('name', 'like', '%' . $buscarpor . '%')->where('idrol', '!=', '1')->paginate(self::PAGINATION);
        return view('auth.index', compact('usuarios', 'buscarpor', 'roles'));
    }

    public function updateUserRole(Request $request): RedirectResponse
    {
    // Validar que el administrador está intentando cambiar el rol
    $validatedData = $request->validate([
        'id' => 'required|exists:users,id',
        'state' => 'required|in:0,1', // Asegúrate de validar el estado como solo 0 o 1
        'idrol' => 'required|exists:roles,idrol', // Asegúrate de que este es el nombre de tu campo en la base de datos
    ]);

    // Encontrar al usuario y actualizar su rol y estado
    $user = User::findOrFail($validatedData['id']);
    $user->state = $validatedData['state'];
    $user->idrol = $validatedData['idrol'];
    $user->save();
        return Redirect::route('listauser')->with('status', 'Rol actualizado con éxito.');
    }
}
