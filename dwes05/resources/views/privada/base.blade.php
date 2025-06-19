<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title><!-- Aqui iria el titulo que le pasariamos a traves de las vistas creadas -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body><!-- En la base he decidido conservar el mensaje de bienvenida, y he puesto los enlaces en una lista, y si el usuario esta registrado mostrara los botones de crear mascota, zona privada y cerrar sesion, aunque esto no seria necesario ya que a esta direccion solo se puede acceder si el usuario esta logeado -->
    <nav>
        <H2>Bienvenido {{ Auth::user()->name}} a la página principal de la zona PRIVADA.</H2>
        <ul>
            <li>
                <a href="{{route('zonapublica')}}">Pagina de inicio</a>
            </li>
            @auth
            <li>
                <a href="{{route('formmascotaACM')}}">Crear nueva mascota</a>
            </li>
            <li>
                <a href="{{route('zonaprivada')}}">Zona privada</a>
            </li>
            <li>
                <A href="{{ route('logout') }}">Cierra sesión</A></BR>
            </li>
            @endauth
            

        </ul>
    </nav>
    <!-- Aqui establecemos el resto del cuerpo que crearemos en cada vista -->
    @yield('contenido')
</body>
</html>