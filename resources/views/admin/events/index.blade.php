@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Meus eventos</h1>
            <p class="text-base-content/70">
                Gerencie os eventos criados por você.
            </p>
        </div>

        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            Novo evento
        </a>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            @if ($events->count())
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Banner</th>
                                <th>Evento</th>
                                <th>Categoria</th>
                                <th>Data</th>
                                <th>Vagas</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $event->banner_path) }}"
                                            alt="Banner do evento {{ $event->title }}" class="w-20 h-14 object-cover rounded">
                                    </td>

                                    <td>
                                        <div class="font-bold">{{ $event->title }}</div>
                                        <div class="text-sm text-base-content/60">
                                            {{ $event->location }}
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
                                        {{ $event->capacity }}
                                    </td>

                                    <td class="text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline">
                                                Editar
                                            </a>

                                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja excluir este evento?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-error">
                                                    Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-10">
                    <h2 class="text-xl font-bold">Nenhum evento cadastrado</h2>
                    <p class="text-base-content/70 mt-2">
                        Crie seu primeiro evento para começar.
                    </p>

                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary mt-4">
                        Cadastrar evento
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection