@extends('base')<!-- Añadimos la base -->

@section('titulo', 'Inicio')<!-- Ponemos el titulo a la pagina -->

@section('contenido')<!-- Añadimos el contenido -->
    <section id='table'>
        <!-- Comprobamos que el listado de mascotas no esta vacio y sacamos una tabla con todas ellas -->
        @if (!$mascotasACM->isEmpty())
        <table>
            <thead>
                <tr>
                    <th>Id</th><th>Nombre</th><th>Descripcion</th><th>Tipo</th><th>Me gustas</th><th>Propietario</th>
                </tr>
            </thead>
            <tbody>
            <!-- Con un bucle foreach vamos sacando cada mascota del array -->
            @foreach ($mascotasACM as $mascota)
                <tr>
                    <td>{{$mascota->id}}</td>
                    <td>{{$mascota->nombre}}</td>
                    <td>{{$mascota->descripcion}}</td>
                    <td>{{$mascota->tipo}}</td>
                    <td>{{$mascota->megusta}}</td>
                    <td>{{$mascota->user->name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </section>
@endsection