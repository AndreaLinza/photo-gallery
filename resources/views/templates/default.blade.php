<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>@yield('title', 'Home')</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="d-flex flex-column h-100">

    {{-- TOGGLE THEME --}}
    @include('partials.toggle_theme')

    {{-- NAVBAR --}}
    @include('partials.navbar')

    <main class="flex-shrink-0">
        <div class="container main-container">
            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    @section('footer')
    @include('partials.footer')
    @show

</body>

</html>
