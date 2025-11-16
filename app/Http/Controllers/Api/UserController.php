<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
            ->select('id', 'name', 'email', 'avatar')
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
        try {
            Log::info('Datos recibidos:', $request->all());
            Log::info('Archivo recibido:', [
                'hasFile' => $request->hasFile('avatar'),
                'isValid' => $request->hasFile('avatar') ? $request->file('avatar')->isValid() : false,
                'fileName' => $request->hasFile('avatar') ? $request->file('avatar')->getClientOriginalName() : null,
            ]);
            // Procesar el avatar si existe
            $avatarPath = null;
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                Log::info('Avatar guardado en:', ['path' => $avatarPath]);
            }

            // Crear el usuario
            $user = User::create([
                'name' => $request['nombre'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'avatar' => $avatarPath,
            ]);

            // Asignar el rol por ID (no por nombre)
            $role = Role::find($request['rol']);
            if ($role) {
                $user->assignRole($role);
            }

            return response()->json([
                'message' => 'Usuario Registrado',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el usuario',
                'error' => $e->getMessage()
            ], 500);
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
            ->select('id', 'name', 'email', 'avatar')
            ->findOrFail($usuario);

        // Si solo tiene un rol, puedes tomar el primero
        $user->rol = $user->roles->pluck('id')->first();
        unset($user->roles); // Opcional: elimina la relación si no la necesitas

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $usuario)
    {
        $user = User::findOrFail($usuario);

        try {
            // Procesar el avatar
            if ($request->has('remove_avatar') && $request->remove_avatar) {
                // Eliminar avatar existente
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                    $user->avatar = null;
                }
            } elseif ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                // Eliminar avatar anterior si existe
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                // Guardar nuevo avatar
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            // Actualizar usuario
            $user->update([
                'name' => $request['nombre'],
                'email' => $request['email'],
            ]);

            // Actualizar rol
            $role = Role::find($request['rol']);
            if ($role) {
                $user->syncRoles([$role]);
            }

            return response()->json([
                'message' => 'Usuario Editado',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
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
        // Eliminar rol del usuario en caso que tenga alguno
        $usuario->roles()->detach();
        
        // Eliminar avatar
        if ($usuario->avatar) {
            Storage::disk('public')->delete($usuario->avatar);
        }

        // Eliminar usuario
        $usuario->delete();

        // Enviar resuesta a la api
        return response()->json(['message' => 'Usuario Eliminado']);
    }
}
