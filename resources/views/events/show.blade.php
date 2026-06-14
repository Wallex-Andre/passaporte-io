@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <a href="{{ route('home') }}#eventos" class="btn btn-ghost">
            ← Voltar para eventos
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-xl overflow-hidden">
                <figure>
                    <img
                        src="{{ asset('storage/' . $event->banner_path) }}"
                        alt="Banner do evento {{ $event->title }}"
                        class="w-full max-h-[420px] object-cover"
                    >
                </figure>

                <div class="card-body">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="badge badge-primary">
                            {{ $event->category->name }}
                        </span>

                        <span class="badge badge-outline">
                            {{ $event->date_time->format('d/m/Y H:i') }}
                        </span>
                    </div>

                    <h1 class="text-4xl font-bold mt-4">
                        {{ $event->title }}
                    </h1>

                    <div class="divider"></div>

                    <h2 class="text-xl font-bold">
                        Descrição
                    </h2>

                    <p class="text-base-content/80 whitespace-pre-line">
                        {{ $event->description }}
                    </p>
                </div>
            </div>
        </div>

        <div>
            <div class="card bg-base-100 shadow-xl sticky top-6">
                <div class="card-body">
                    <h2 class="card-title">
                        Informações do evento
                    </h2>

                    <div class="space-y-3 text-sm mt-4">
                        <p>
                            <strong>Organizador:</strong><br>
                            {{ $event->user->name }}
                        </p>

                        <p>
                            <strong>Local:</strong><br>
                            {{ $event->location }}
                        </p>

                        <p>
                            <strong>Data e horário:</strong><br>
                            {{ $event->date_time->format('d/m/Y H:i') }}
                        </p>

                        <p>
                            <strong>Capacidade:</strong><br>
                            {{ $event->capacity }} vagas
                        </p>

                        <p>
                            <strong>Inscritos:</strong><br>
                            {{ $occupied }}
                        </p>

                        <p>
                            <strong>Vagas disponíveis:</strong><br>
                            {{ $available }}
                        </p>
                    </div>

                    <div class="divider"></div>

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary w-full">
                            Entrar para se inscrever
                        </a>
                    @else
                        @if (auth()->user()->role === 'organizador')
                            <div class="alert alert-warning">
                                <span>
                                    Organizadores não podem se inscrever em eventos.
                                </span>
                            </div>
                        @elseif ($alreadyEnrolled)
                            <div class="alert alert-success">
                                <span>
                                    Você já está inscrito neste evento.
                                </span>
                            </div>

                            <a href="{{ route('enrollments.index') }}" class="btn btn-outline w-full">
                                Ver minhas inscrições
                            </a>

                            <form
                                action="{{ route('enrollments.destroy', $event) }}"
                                method="POST"
                                onsubmit="return confirm('Tem certeza que deseja cancelar esta inscrição?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-error w-full mt-2">
                                    Cancelar inscrição
                                </button>
                            </form>
                        @elseif ($isFull)
                            <button class="btn btn-disabled w-full">
                                Vagas esgotadas
                            </button>
                        @else
                            <form action="{{ route('events.enroll', $event) }}" method="POST">
                                @csrf

                                <button type="submit" class="btn btn-primary w-full">
                                    Inscrever-se
                                </button>
                            </form>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </div>
@endsection