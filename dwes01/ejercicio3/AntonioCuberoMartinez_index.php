
<form action='AntonioCuberoMartinez_datos.php' method='post'>
    <h3>Introduzca un precio máximo</h3>
    <label for='price'>Precio</label>
    <input type='text' name='price'><br>
    <h3>Seleccione el tipo de vehiculo</h3>
    <ul style='list-style: none;'>
        <li>
            <input type='checkbox' name='class[]' value='compacto'>
            <label for='compacto'>Compacto</label>
        </li>
        <li>
            <input type='checkbox' name='class[]' value='berlina'>
            <label for='berlina'>Berlina</label>
        </li>
        <li>
            <input type='checkbox' name='class[]' value='deportivo'>
            <label for='deportivo'>Deportivo</label>
        </li>
        <li>
            <input type='checkbox' name='class[]' value='SUV'>
            <label for='SUV'>SUV</label>
        </li>
        <li>
            <input type='checkbox' name='class[]' value='todoterreno'>
            <label for='todoterreno'>Todoterreno</label>
        </li>
        <li>
            <input type='checkbox' name='class[]' value='test'>
            <label for='todoterreno'>Test</label>
        </li>
    </ul>
    <input type='submit'>
</form>