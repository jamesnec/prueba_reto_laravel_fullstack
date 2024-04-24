<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Prueba tipo de cambio Laravel</title>
    <meta name="theme-color" content="#00204B">

    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css?v=1.0') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    
    <script src="{{ asset('assets/js/app.min.js?v=1.0') }}"></script>    
    <script src="{{ asset('assets/js/materialize.min.js') }}"></script>
    <script src="{{ asset('assets/js/all.min.js?v=1.0') }}"></script>
</body>
</html>