@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h1 class="card-title text-2xl">Login</h1>

                <p class="text-base-content/70">
                    Acesse sua conta no Passaporte.io.
                </p>

                <form action="{{ route('login.store') }}" method="POST" class="space-y-4 mt-4">
                    @csrf

                    <div>
                        <label class="label" for="email">
                            <span class="label-text">E-mail</span>
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="input input-bordered w-full @error('email') input-error @enderror"
                            placeholder="seuemail@exemplo.com"
                        >

                        @error('email')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label" for="password">
                            <span class="label-text">Senha</span>
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="input input-bordered w-full @error('password') input-error @enderror"
                            placeholder="Sua senha"
                        >

                        @error('password')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-full">
                        Entrar
                    </button>
                </form>

                <p class="text-sm text-center mt-4">
                    Ainda não tem conta?
                    <a href="{{ route('register') }}" class="link link-primary">
                        Criar conta
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection