<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('asset/Logo.jpg') }}" />
    <link rel="canonical" href="{{ route('siswa.dashboard') }}" />
    <title>@yield('judul')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    @notifyCss
</head>

<body data-success="{{ session('success') }}" data-error="{{ session('error') }}"
    data-errors='@json($errors->all())'>
    <div class="wrapper">
        @include('layouts.auth.sidebar')
        <div class="main">
            @include('layouts.auth.navbar')
            <main class="content">
                <div class="container-fluid p-0">
                    @yield('content')
                    <x-modal />
                </div>
            </main>
            @include('layouts.auth.footer')
        </div>
    </div>
    @include('layouts.auth.scripts')
    @notifyJs
    {{-- @notifyRender --}}
</body>

</html>
