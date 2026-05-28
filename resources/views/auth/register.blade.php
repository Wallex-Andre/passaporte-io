@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h1 class="card-title text-2xl">Criar conta</h1>

                <p class="text-base-content/70">
                    Cadastre-se para acessar o Passaporte.io.
                </p>

                <form action="{{ route('register.store') }}" method="POST" class="space-y-4 mt-4">
                    @csrf

                    <div>
                        <label class="label" for="name">
                            <span class="label-text">Nome</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="input input-bordered w-full @error('name') input-error @enderror"
                            placeholder="Seu nome completo"
                        >

                        @error('name')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

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
                        <label class="label" for="role">
                            <span class="label-text">Perfil</span>
                        </label>

                        <select
                            id="role"
                            name="role"
                            class="select select-bordered w-full @error('role') select-error @enderror"
                        >
                            <option value="">Selecione seu perfil</option>
                            <option value="participante" @selected(old('role') === 'participante')>
                                Participante
                            </option>
                            <option value="organizador" @selected(old('role') === 'organizador')>
                                Organizador
                            </option>
                        </select>

                        @error('role')
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
                            placeholder="Mínimo 8 caracteres"
                        >

                        @error('password')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label" for="password_confirmation">
                            <span class="label-text">Confirmar senha</span>
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="input input-bordered w-full"
                            placeholder="Digite a senha novamente"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-full">
                        Criar conta
                    </button>
                </form>

                <p class="text-sm text-center mt-4">
                    Já tem conta?
                    <a href="{{ route('login') }}" class="link link-primary">
                        Entrar
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection