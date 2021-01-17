<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="nav">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (Auth::user() && Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link active" href="/admin">Админ-панель</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link active" href="/">Главная</a>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a class="nav-link active" href="/login">Вход</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/register">Регистрация</a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item">
                            <a class="nav-link active" href="/history">История операций</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/logout">Выход</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<script src="/js/app.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>