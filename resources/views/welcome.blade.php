<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <section class="hero text-center py-5">
            <div class="container">
                <h2>Eleve seus torneios de poker a um novo nível!</h2>
                <p class="lead">O Poker Home oferece recursos poderosos e uma interface intuitiva para simplificar a
                    organização e gestão do seu próximo evento.</p>
                <div class="row mt-5">
                    <div class="col-lg-4">
                        <div class="card">
                            <img src="{{ asset('img/landing-page-1.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Agendamento Simplificado</h5>
                                <p class="card-text">Crie e gerencie facilmente o cronograma do seu torneio com nosso sistema intuitivo de agendamento.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <img src="{{ asset('img/landing-page-2.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Registro de Participantes</h5>
                                <p class="card-text">Realize a inscrição dos participantes nos torneios criados por você</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <img src="{{ asset('img/landing-page-3.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Gerar relatórios detalhados</h5>
                                <p class="card-text">Gere relatorios detalhados de quanto os jogadores gastaram no torneio.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Resto do conteúdo aqui -->

        <footer class="bg-dark text-light py-3">
            <div class="container">
                <p>&copy; 2024 Poker Home. Todos os direitos reservados. <a href="#">Termos de Serviço</a>. <a
                        href="#">Política de Privacidade</a>.</p>
            </div>
        </footer>
    </body>
</html>
