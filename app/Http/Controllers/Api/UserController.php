<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obteniendo nombre de roles y id, nombre de usuarios

        $users = User::with('roles:id,name')
            ->select('id', 'name', 'email')
            ->get()
            ->map(function ($user) {
                // Si solo tiene un rol, puedes tomar el primero
                $user->rol = $user->roles->pluck('name')->first();
                return $user;
            });

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Creando Usuario
        $user = new User;

        $user->name = $request->nombre;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            $user->assignRole($request->rol);
            return response()->json(['message' => 'Usuario Registrado'], 200);
        }
    }

    /**
     * Metodo para obtener Roles
     */
    public function getRoles(/* string $id */)
    {
        $roles = Role::select('id', 'name')->get();
        return response()->json($roles);
    }

    // Metodo para Obtener datos del usuario
    function show($usuario)
    {
        $user = User::with('roles:id,name')
            ->select('id', 'name', 'email')
            ->findOrFail($usuario);

        // Si solo tiene un rol, puedes tomar el primero
        $user->rol = $user->roles->pluck('id')->first();
        unset($user->roles); // Opcional: elimina la relación si no la necesitas

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
        $usuario->name = $request->nombre;
        $usuario->email = $request->email;
        // con el syncRoles se remplaza el rol actual por el nuevo
        $usuario->syncRoles($request->rol);

        $usuario->save();

        return response()->json(['message' => 'Usuario Editado'], 200);
    }

    // Metodo para Actualizar Contraseña
    public function updatePassword(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($usuario) {
                    if (!Hash::check($value, $usuario->password)) {
                        $fail('La contraseña actual es incorrecta');
                    }
                }
            ],
            'new_password' => [
                'required',
                'different:current_password',
                'confirmed',
            ]
        ]);

        $usuario->password = Hash::make($validated['new_password']);
        $usuario->save();

        return response()->json([
            'message' => 'Contraseña Editada'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        // Eliminar rol del usuario
        $usuario->removeRole($usuario->roles->implode('name', ','));

        // Eliminar usuario
        $usuario->delete();

        // Enviar resuesta a la api
        return response()->json(['message' => 'Usuario Eliminado']);
    }
}
