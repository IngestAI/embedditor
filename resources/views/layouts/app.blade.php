<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="d-flex flex-column h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Embedditor') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

</head>
<body class="d-flex flex-column h-100">
<div id="app" class="d-flex flex-column h-100">
    <header class="navbar navbar-expand-md navbar-light bg-body-tertiary shadow-sm">
        <nav class="container">
            <a class="navbar-brand me-2" href="{{ route('web::library::index') }}">
                <img src="/images/logo.jpg" alt="Embedditor logo" width="30" height="30" class="d-inline-block align-text-center mr-1">
                <span class="h6">{{ config('app.name', 'Embedditor') }}</span>
            </a>
        </nav>
    </header>

    <main class="container my-md-4">
        @yield('content')
    </main>

    <footer class="py-3 mt-auto">
        <div class="container">
            <p class="text-right text-muted">&copy; <script>document.write(new Date().getFullYear())</script>. IngestAI Labs Inc.</p>
        </div>
    </footer>
</div>
<script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
@yield('js')
</body>
</html>
