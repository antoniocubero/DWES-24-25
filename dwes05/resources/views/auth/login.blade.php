@extends('base')<!-- Añadimos la base -->

@section('titulo', 'Login')<!-- Ponemos el titulo a la pagina -->

@section('contenido')<!-- Añadimos el contenido -->

@auth <!-- Si el usuario ya hubiese iniciado sesion, mostraria un enlace a la zona privada -->
<section>
    <h1>Ya has iniciado sesión</h1>
    <a href="{{ route('zonaprivada') }}">Ir a zona privada</a>
</section>
@endauth

<!-- Si no esta logeado mostraria el formulario de inicio de sesion -->
@guest
    <section>
        <h1>Iniciar Sesión</h1>
        <!-- Si los credenciales no fuesen correctos los mostraria -->
        @if ($errors->any())
        <div style="color: red;">
            <H2>ERRORES:</H2>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        
        <form id='form-login' method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password">
            <input type="submit" value="Login">
        </form>
        @endguest
    </section>
@endsection
