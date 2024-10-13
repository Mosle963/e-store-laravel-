<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{$extra_style ?? ''}}
    <title>e-store | {{$title ?? 'home'}}</title>
    @livewireStyles
    <style>

    </style>
</head>
<body>
    @include('layouts.header')



    <main class="container mx-auto mt-5">
    {{$slot ?? ''}}
    @yield('main')
    </main>



    <footer class="bg-light text-center py-3 mt-5">
        <p>© 2024 e-store. All rights reserved.</p>
        <p>by Mohammad Soleman</p>
    </footer>
    @livewireScripts
    {{$extra_script ?? ''}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>

