<?php

require __DIR__.'/vendor/autoload.php';

session_start();

//Si el usuario esta logeado sacamos el formulario
if (isset($_SESSION['token'])) {
    echo "<h2>Crear mascota</h2>
        <form method='POST' action='crearmascota.php'>
            <label for='nombre'>Nombre de la mascota:</label>
            <input type='text' id='nombre' name='nombre'><br>
            <label for='descripcion'>Descripcion:</label>
            <textarea id='descripcion' name='descripcion' cols='30' ></textarea><br>
            <label for='tipo'>Tipo de mascota:</label>
            <select name='tipo' id=''>
                <option value=''>Elige una opcion</option>
                <option value='Perro'>Perro</option>
                <option value='Gato'>Gato</option>
                <option value='Pájaro'>Pájaro</option>
                <option value='Dragón'>Dragón</option>
                <option value='Conejo'>Conejo</option>
                <option value='Hamster'>Hamster</option>
                <option value='Tortuga'>Tortuga</option>
                <option value='Pez'>Pez</option>
                <option value='Serpiente'>Serpiente</option>
            </select><br>
            <label for='publica'>¿Publica?</label><br>
            <input type='radio' id='publica_si' name='publica' value='Si'>
            <label for='publica_si'>Sí</label>
            <input type='radio' id='publica_no' name='publica' value='No'>
            <label for='publica_no'>No</label><br>
            <input type='submit' value='Crear'>
        </form>";

}else{//Si no lo esta le pondremos un link para redireccionarlo al login
    echo "<a href='login.php'>Por favor, inicia sesion</a>";
}

