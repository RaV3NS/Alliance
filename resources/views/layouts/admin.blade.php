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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap.min.css">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin">Главная</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/transactions">Транзакции</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="/">Вернуться на сайт</a>
                    </li>
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