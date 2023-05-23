<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="d-flex flex-column h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="57x57" href="/images/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <title>{{ config('app.name', 'Embedditor') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    @yield('css')
</head>
<body class="d-flex flex-column h-100">
<div id="app" class="d-flex flex-column h-100">
    <header class="navbar navbar-expand-md navbar-light bg-body-tertiary shadow-sm">
        <nav class="container">
            <a class="navbar-brand me-2" href="{{ route('web::library::index') }}">
                <img src="/images/logo.jpg" alt="Embedditor logo" width="30" height="30" class="d-inline-block align-text-center mr-1">
                <span class="h6">{{ config('app.name', 'Embedditor') }}</span>
            </a>

            @yield('button')
        </nav>
    </header>

    <main class="container my-md-4">
        @yield('content')
    </main>

    <footer class="py-3 mt-auto">
        <div class="container">
            <p class="text-right text-muted">&copy; <script>document.write(new Date().getFullYear())</script>. <a href="https://ingestai.io" target="_blank">IngestAI</a> Labs Inc.</p>
        </div>
    </footer>
</div>
<script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

@yield('js')
</body>
</html>
