@extends('privada.base')<!-- Añadimos la base privada -->

@section('titulo', 'Nueva mascota')<!-- Ponemos el titulo a la pagina -->

@section('contenido')<!-- Añadimos el contenido -->
    <section>
        <!-- Si nos devuelve errores los sacamos -->
        @if ($errors->any())
            <H3>Se han producido errores en el formulario:</H3>
            <UL>
                @foreach ($errors->all() as $error)
                    <LI>{{ $error }}</LI>
                @endforeach
            </UL>
        @endif
        <!-- Creamos el formulario -->
        <form method="POST" action="{{ route('nuevamascotaACM') }}">
            @csrf <!-- Añadimos la etiqueta @csrf -->
            <label for="nombre">Nombre de la mascota:</label>
            <input type="text" id="nombre" name="nombre">
            <label for="descripcion">Descripcion:</label>
            <textarea id="descripcion" name="descripcion" cols="30" rows="10"></textarea>
            <label for="tipo">Tipo de mascota:</label>
            <select name="tipo" id="">
                <option value="">Elige una opcion</option>
                <option value="Perro">Perro</option>
                <option value="Gato">Gato</option>
                <option value="Pájaro">Pájaro</option>
                <option value="Dragón">Dragón</option>
                <option value="Conejo">Conejo</option>
                <option value="Hamster">Hamster</option>
                <option value="Tortuga">Tortuga</option>
                <option value="Pez">Pez</option>
                <option value="Serpiente">Serpiente</option>
            </select>
            <p>
                <label for="publica">¿Publica?</label><br>
                <input type="radio" id="publica_si" name="publica" value="Si">
                <label for="publica_si">Sí</label>
                <input type="radio" id="publica_no" name="publica" value="No">
                <label for="publica_no">No</label>
            </p>
            <input type="submit" value="Crear">
        </form>
    </section>
@endsection