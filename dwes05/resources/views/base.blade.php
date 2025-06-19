<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title><!-- Aqui iria el titulo que le pasariamos en las vistas creadas -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <nav>
        <H2>Bienvenido a la página principal PÚBLICA.</H2>
        <ul>
            <li>
                <a href="{{route('zonapublica')}}">Pagina de inicio</a>
            </li>
            <!-- Aqui he decidido mostrar los botones de la zona privada, y cerrar sesion si el usuario esta autenticado -->
            @auth
            <li>
                <a href="{{route('zonaprivada')}}">Zona privada</a>
            </li>
            <li>
                <A href="{{ route('logout') }}">Cierra sesión</A></BR>
            </li>
            @endauth
            <!-- Si no lo esta solo mostrara iniciar sesion -->
            @guest
            <li>
                <A href="{{ route('formlogin') }}">Iniciar sesión</A><BR>
            </li>
            @endguest

        </ul>
    </nav>
    <!-- Aqui establecemos el resto del cuerpo que crearemos en cada vista -->
    @yield('contenido')
</body>
</html>