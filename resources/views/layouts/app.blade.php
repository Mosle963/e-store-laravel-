<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
    rel="stylesheet">
    {{$extra_style ?? ''}}
    <title>e-store | {{$title ?? 'home'}}</title>
    @livewireStyles
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>{{$h1 ?? 'E-store'}}</h1>
        @include('layouts/navbar')
    </header>
    <main class="container mx-auto mt-5">
    {{$slot ?? 'welcome'}}
    </main>



    <footer class="bg-light text-center py-3 mt-5">
        <p>© 2024 e-store. All rights reserved.</p>
        <p>by Mohammad Soleman</p>
    </footer>
    @livewireScripts
    {{$extra_script ?? ''}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js">
    </script>
</body>
</html>
