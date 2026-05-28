<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'role' => ['required', 'in:participante,organizador'],
                'password' => ['required', 'min:8', 'confirmed'],
            ],
            [
                'name.required' => 'O nome é obrigatório.',
                'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
                'email.required' => 'O e-mail é obrigatório.',
                'email.email' => 'Informe um e-mail válido.',
                'email.unique' => 'Este e-mail já está cadastrado.',
                'role.required' => 'Selecione um perfil.',
                'role.in' => 'O perfil selecionado é inválido.',
                'password.required' => 'A senha é obrigatória.',
                'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
                'password.confirmed' => 'A confirmação da senha não confere.',
            ]
        );

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()
            ->route('home')
            ->with('success', 'Conta criada com sucesso!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ],
            [
                'email.required' => 'O e-mail é obrigatório.',
                'email.email' => 'Informe um e-mail válido.',
                'password.required' => 'A senha é obrigatória.',
            ]
        );

        if (! Auth::attempt($credentials)) {
            return back()
                ->withInput()
                ->with('error', 'E-mail ou senha inválidos.');
        }

        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('success', 'Login realizado com sucesso!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('success', 'Logout realizado com sucesso!');
    }
}