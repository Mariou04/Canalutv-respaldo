<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        if (!auth()->check() || auth()->user()->rol_id != 1) {
            abort(403, 'No tienes permisos para registrar usuarios');
        }
        
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if (!auth()->check() || auth()->user()->rol_id != 1) {
            abort(403, 'No tienes permisos para registrar usuarios');
        }

        // DEBUG
        \Log::info('Datos del formulario:', $request->all());

        $request->validate([
            'nombre' => ['required', 'string', 'max:255'], // Cambié name por nombre
            'apellido' => ['required', 'string', 'max:255'], // Agregué apellido
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,periodista']
        ]);

        try {
            $user = User::create([
                'nombre' => $request->nombre, // Cambié name por nombre
                'apellido' => $request->apellido, // Agregué apellido
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol_id' => $request->role === 'admin' ? 1 : 2,
                'activo' => true
            ]);

            \Log::info('Usuario creado exitosamente:', $user->toArray());

            event(new Registered($user));

            return redirect()->route('admin.gestion-usuarios')->with('success', 'Usuario registrado exitosamente');

        } catch (\Exception $e) {
            \Log::error('Error al crear usuario: ' . $e->getMessage());
            return back()->with('error', 'Error al registrar usuario: ' . $e->getMessage())->withInput();
        }
    }
}