@extends('privada.base')<!-- Añadimos la base privada -->

@section('titulo', 'Zona privada')<!-- Ponemos el titulo a la pagina -->

@section('contenido')<!-- Añadimos el contenido -->


<section>
    <!-- Si nos devuelve errores los sacamos -->
    @if ($errors->any())
        <H3>Se han producido errores:</H3>
        <UL>
            @foreach ($errors->all() as $error)
                <LI>{{ $error }}</LI>
            @endforeach
        </UL>
    @endif
    
    <!-- Comprobamos que el listado de mascotas no esta vacio y sacamos una tabla con todas ellas -->
    @if (!$mascotasACM->isEmpty())
    <table>
        <thead>
            <tr>
                <th>Id</th><th>Nombre</th><th>Descripcion</th><th>Tipo</th><th>Me gustas</th><th>¿Pública?</th><th>Propietario</th><th>Cambiar privacidad</th>
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
                <td>{{$mascota->publica}}</td>
                <td>{{$mascota->user->name}}</td>
                <td>
                    <!-- Creamos un form para el boton de cambiar la privacidad -->
                    <form method='post' action="{{route('cambiarprivacidadACM')}}">
                        @csrf
                        <input type="hidden" name="id" value='{{$mascota->id}}'>
                        <!-- Comprobamos si la mascota es publica para cambiar el texto del boton -->
                        <input type="submit" value="Cambiar a {{$mascota->publica == 'Si' ? 'privada':'publica'}}">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</section>
@endsection