@extends('privada.base')<!-- Añadimos la base privada -->

@section('titulo', 'Mascota creada')<!-- Ponemos el titulo a la pagina -->

@section('contenido')<!-- Añadimos el contenido -->
<section>
    <h1>Mascota creada con id: {{$mascota->id}} - Antonio Cubero Martinez</h1>
</section>
@endsection
