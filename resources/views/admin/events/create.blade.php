@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">Cadastrar evento</h1>
            <p class="text-base-content/70">
                Preencha os dados do evento. O banner é obrigatório.
            </p>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <div>
                        <label class="label" for="title">
                            <span class="label-text">Título</span>
                        </label>

                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                            class="input input-bordered w-full @error('title') input-error @enderror"
                            placeholder="Ex: Workshop de Laravel">

                        @error('title')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label" for="category_id">
                            <span class="label-text">Categoria</span>
                        </label>

                        <select id="category_id" name="category_id"
                            class="select select-bordered w-full @error('category_id') select-error @enderror">
                            <option value="">Selecione uma categoria</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label" for="description">
                            <span class="label-text">Descrição</span>
                        </label>

                        <textarea id="description" name="description" rows="5"
                            class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
                            placeholder="Descreva o evento">{{ old('description') }}</textarea>

                        @error('description')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="label" for="date_time">
                                <span class="label-text">Data e hora</span>
                            </label>

                            <input type="datetime-local" id="date_time" name="date_time" value="{{ old('date_time') }}"
                                class="input input-bordered w-full @error('date_time') input-error @enderror">

                            @error('date_time')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="label" for="capacity">
                                <span class="label-text">Vagas</span>
                            </label>

                            <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" min="1"
                                step="1"
                                oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value !== '' && this.value < 1) this.value = 1;"
                                onkeydown="return !['e', 'E', '+', '-', '.', ','].includes(event.key)"
                                class="input input-bordered w-full @error('capacity') input-error @enderror"
                                placeholder="Ex: 100">

                            @error('capacity')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="label" for="location">
                            <span class="label-text">Local</span>
                        </label>

                        <input type="text" id="location" name="location" value="{{ old('location') }}"
                            class="input input-bordered w-full @error('location') input-error @enderror"
                            placeholder="Ex: Auditório principal">

                        @error('location')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label" for="banner">
                            <span class="label-text">Banner</span>
                        </label>

                        <input type="file" id="banner" name="banner" accept="image/*"
                            class="file-input file-input-bordered w-full @error('banner') file-input-error @enderror">

                        <p class="text-sm text-base-content/60 mt-1">
                            Envie uma imagem de até 2MB.
                        </p>

                        @error('banner')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between pt-4">
                        <a href="{{ route('admin.events.index') }}" class="btn btn-ghost">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Salvar evento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection