@extends('privada.base')<!-- Añadimos la base privada -->

@section('titulo', 'Mascota creada')<!-- Ponemos el titulo a la pagina -->

@section('contenido')<!-- Añadimos el contenido -->
<section>
    <h1>Privacidad de la mascota: {{$mascota->id}} cambiada a {{$mascota->publica=='Si'?'publica':'privada'}}</h1>
</section>
@endsection