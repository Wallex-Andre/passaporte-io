<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Passaporte.io' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-base-200 text-base-content">

    <div class="navbar bg-base-100 shadow-md px-6">
        <div class="flex-1">
            <a href="{{ route('home') }}" class="text-xl font-bold text-primary">
                Passaporte.io
            </a>
        </div>

        <div class="flex items-center gap-2">
            @auth
                <span class="text-sm text-base-content/70">
                    {{ Auth::user()->name }} · {{ Auth::user()->role }}
                </span>

                @if (Auth::user()->role === 'organizador')
                    <a href="{{ route('admin.events.index') }}" class="btn btn-ghost">
                        Meus eventos
                    </a>
                @endif

                @if (Auth::user()->role === 'participante')
                    <a href="{{ route('enrollments.index') }}" class="btn btn-ghost">
                        Minhas inscrições
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost">
                        Sair
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost">
                    Login
                </a>

                <a href="{{ route('register') }}" class="btn btn-primary">
                    Criar conta
                </a>
            @endauth
        </div>
    </div>

    <main class="container mx-auto px-4 py-8">
        @if (session('success'))
            <div class="flash-message alert alert-success mb-4 transition-opacity duration-500">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="flash-message alert alert-error mb-4 transition-opacity duration-500">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const messages = document.querySelectorAll('.flash-message');

        messages.forEach(function (message) {
            setTimeout(function () {
                message.classList.add('opacity-0');

                setTimeout(function () {
                    message.remove();
                }, 500);
            }, 5000);
        });
    });
</script>
</body>

</html>