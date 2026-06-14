@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Minhas inscrições</h1>
            <p class="text-base-content/70">
                Veja seus eventos inscritos e seus códigos de ingresso.
            </p>
        </div>

        <a href="{{ route('home') }}" class="btn btn-ghost">
            Voltar para eventos
        </a>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            @if ($events->count())
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Evento</th>
                                <th>Categoria</th>
                                <th>Data</th>
                                <th>Ingresso</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>
                                        <div class="font-bold">{{ $event->title }}</div>
                                        <div class="text-sm text-base-content/60">
                                            Organizador: {{ $event->user->name }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge badge-outline">
                                            {{ $event->category->name }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $event->date_time->format('d/m/Y H:i') }}
                                    </td>

                                    <td>
                                        <span class="font-mono">
                                            {{ $event->pivot->ticket_code }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge badge-success">
                                            {{ $event->pivot->status }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-primary">
                                                Ver detalhes
                                            </a>

                                            <form action="{{ route('enrollments.destroy', $event) }}" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja cancelar esta inscrição?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-error w-full sm:w-auto">
                                                    Cancelar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6">
                        {{ $events->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-10">
                    <p class="text-lg text-base-content/70">
                        Você ainda não se inscreveu em nenhum evento.
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-4">
                        Ver eventos
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection