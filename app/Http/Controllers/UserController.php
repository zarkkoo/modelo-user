<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
  
    public function get()
    {
        $users = User::paginate(10);
        return response()->json($users, 200);
    }

    
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user' => $user
        ], 201);
    }

    
    public function login(Request $request)
    *   {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        return response()->json([
            'message' => 'Login exitoso',
            'user' => $user
        ], 200);
    }

    
    private function verifyUserCredentials(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return null;
        }

        return $user;
    }

   
    public function updateUsername(Request $request)
    {
        $user = $this->verifyUserCredentials($request);

        if (! $user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $request->validate([
            'new_username' => 'required|string|max:255',
        ]);

        $user->name = $request->new_username;
        $user->save();

        return response()->json([
            'message' => 'Username actualizado exitosamente',
            'user' => $user
        ], 200);
    }

    
    public function updateEmail(Request $request)
    {
        $user = $this->verifyUserCredentials($request);

        if (! $user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $request->validate([
            'new_email' => 'required|string|email|max:255|unique:users,email',
        ]);

        $user->email = $request->new_email;
        $user->save();

        return response()->json([
            'message' => 'Email actualizado exitosamente',
            'user' => $user
        ], 200);
    }

    
    public function updatePassword(Request $request)
    {
        $user = $this->verifyUserCredentials($request);

        if (! $user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Contraseña actualizada exitosamente'
        ], 200);
    }

   
    public function destroy(Request $request)
    {
        $user = $this->verifyUserCredentials($request);

        if (! $user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente'
        ], 200);
    }
}