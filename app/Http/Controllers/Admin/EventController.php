<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'category_id' => ['required', 'exists:categories,id'],
                'title' => ['required', 'string', 'min:5', 'max:255'],
                'description' => ['required', 'string', 'min:10'],
                'date_time' => ['required', 'date', 'after:now'],
                'location' => ['required', 'string', 'max:255'],
                'capacity' => ['required', 'integer', 'min:1'],
                'banner' => ['required', 'image', 'max:2048'],
            ],
            [
                'category_id.required' => 'Selecione uma categoria.',
                'category_id.exists' => 'A categoria selecionada é inválida.',

                'title.required' => 'O título é obrigatório.',
                'title.min' => 'O título deve ter pelo menos 5 caracteres.',
                'title.max' => 'O título não pode passar de 255 caracteres.',

                'description.required' => 'A descrição é obrigatória.',
                'description.min' => 'A descrição deve ter pelo menos 10 caracteres.',

                'date_time.required' => 'A data e hora do evento são obrigatórias.',
                'date_time.date' => 'Informe uma data válida.',
                'date_time.after' => 'A data do evento deve ser futura.',

                'location.required' => 'O local é obrigatório.',
                'location.max' => 'O local não pode passar de 255 caracteres.',

                'capacity.required' => 'A quantidade de vagas é obrigatória.',
                'capacity.integer' => 'A quantidade de vagas deve ser um número inteiro.',
                'capacity.min' => 'O evento deve ter pelo menos 1 vaga.',

                'banner.required' => 'O banner é obrigatório.',
                'banner.image' => 'O arquivo enviado deve ser uma imagem.',
                'banner.max' => 'O banner não pode ter mais de 2MB.',
            ]
        );

        $bannerPath = $request->file('banner')->store('banners', 'public');

        Event::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date_time' => $validated['date_time'],
            'location' => $validated['location'],
            'capacity' => $validated['capacity'],
            'banner_path' => $bannerPath,
        ]);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento cadastrado com sucesso!');
    }

    public function edit(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $categories = Category::orderBy('name')->get();

        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        $validated = $request->validate(
            [
                'category_id' => ['required', 'exists:categories,id'],
                'title' => ['required', 'string', 'min:5', 'max:255'],
                'description' => ['required', 'string', 'min:10'],
                'date_time' => ['required', 'date', 'after:now'],
                'location' => ['required', 'string', 'max:255'],
                'capacity' => ['required', 'integer', 'min:1'],
                'banner' => ['nullable', 'image', 'max:2048'],
            ],
            [
                'category_id.required' => 'Selecione uma categoria.',
                'category_id.exists' => 'A categoria selecionada é inválida.',

                'title.required' => 'O título é obrigatório.',
                'title.min' => 'O título deve ter pelo menos 5 caracteres.',
                'title.max' => 'O título não pode passar de 255 caracteres.',

                'description.required' => 'A descrição é obrigatória.',
                'description.min' => 'A descrição deve ter pelo menos 10 caracteres.',

                'date_time.required' => 'A data e hora do evento são obrigatórias.',
                'date_time.date' => 'Informe uma data válida.',
                'date_time.after' => 'A data do evento deve ser futura.',

                'location.required' => 'O local é obrigatório.',
                'location.max' => 'O local não pode passar de 255 caracteres.',

                'capacity.required' => 'A quantidade de vagas é obrigatória.',
                'capacity.integer' => 'A quantidade de vagas deve ser um número inteiro.',
                'capacity.min' => 'O evento deve ter pelo menos 1 vaga.',

                'banner.image' => 'O arquivo enviado deve ser uma imagem.',
                'banner.max' => 'O banner não pode ter mais de 2MB.',
            ]
        );

        $bannerPath = $event->banner_path;

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        $event->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date_time' => $validated['date_time'],
            'location' => $validated['location'],
            'capacity' => $validated['capacity'],
            'banner_path' => $bannerPath,
        ]);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }

        if ($event->participants()->exists()) {
            return back()
                ->with('error', 'Não é possível excluir um evento com inscrições ativas.');
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento excluído com sucesso!');
    }
}
