@extends('layouts.app')

@section('content')
    <section class="hero min-h-[70vh] bg-base-100 rounded-box shadow">
        <div class="hero-content text-center">
            <div class="max-w-2xl">

                <div class="badge badge-primary mb-4">
                    Laravel + DaisyUI
                </div>

                <h1 class="text-5xl font-bold">
                    Passaporte.io
                </h1>

                <p class="py-6 text-base-content/70">
                    Sistema de gestão de eventos e ingressos.
                </p>

                <div class="flex justify-center gap-3">
                    <a href="#" class="btn btn-primary">
                        Ver eventos
                    </a>

                    <a href="#" class="btn btn-outline">
                        Área do organizador
                    </a>
                </div>

            </div>
        </div>
    </section>
@endsection