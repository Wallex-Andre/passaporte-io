@extends('layouts.app')

@section('content')
    <section class="hero min-h-[55vh] bg-base-100 rounded-box shadow mb-10">
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
                    <a href="#eventos" class="btn btn-primary">
                        Ver eventos
                    </a>

                    @auth
                        @if (auth()->user()->role === 'organizador')
                            <a href="{{ route('admin.events.index') }}" class="btn btn-outline">
                                Área do organizador
                            </a>
                        @elseif (auth()->user()->role === 'participante')
                            <a href="{{ route('enrollments.index') }}" class="btn btn-outline">
                                Minhas inscrições
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline">
                            Entrar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <section id="eventos">
        <div class="mb-8">
            <h2 class="text-3xl font-bold">
                Eventos disponíveis
            </h2>

            <p class="text-base-content/70 mt-2">
                Veja os eventos cadastrados, confira as informações completas e faça sua inscrição.
            </p>
        </div>

        <div class="mb-8 flex flex-wrap gap-2">
            <a
                href="{{ route('home') }}#eventos"
                class="btn btn-sm {{ request('category') ? 'btn-outline' : 'btn-primary' }}"
            >
                Todos
            </a>

            @foreach ($categories as $category)
                <a
                    href="{{ route('home', ['category' => $category->id]) }}#eventos"
                    class="btn btn-sm {{ request('category') == $category->id ? 'btn-primary' : 'btn-outline' }}"
                >
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        @if ($events->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div class="card bg-base-100 shadow-xl overflow-hidden">
                        <figure>
                            <img
                                src="{{ asset('storage/' . $event->banner_path) }}"
                                alt="Banner do evento {{ $event->title }}"
                                class="h-48 w-full object-cover"
                            >
                        </figure>

                        <div class="card-body">
                            <div class="flex items-center justify-between gap-2">
                                <span class="badge badge-primary">
                                    {{ $event->category->name }}
                                </span>

                                <span class="text-sm text-base-content/60">
                                    {{ $event->date_time->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            <h3 class="card-title mt-2">
                                {{ $event->title }}
                            </h3>

                            <p class="text-sm text-base-content/70 whitespace-pre-line">
                                {{ $event->description }}
                            </p>

                            <div class="text-sm mt-2 space-y-1">
                                <p>
                                    <strong>Organizador:</strong>
                                    {{ $event->user->name }}
                                </p>

                                <p>
                                    <strong>Local:</strong>
                                    {{ $event->location }}
                                </p>

                                <p>
                                    <strong>Capacidade:</strong>
                                    {{ $event->capacity }} vagas
                                </p>
                            </div>

                            <div class="card-actions justify-end mt-4">
                                <a
                                    href="{{ route('events.show', $event) }}"
                                    class="btn btn-primary"
                                >
                                    Ver detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $events->links() }}
            </div>
        @else
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body text-center">
                    <h3 class="text-2xl font-bold">
                        Nenhum evento encontrado
                    </h3>

                    <p class="text-base-content/70">
                        Não há eventos disponíveis para esta categoria no momento.
                    </p>

                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            Ver todos os eventos
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection