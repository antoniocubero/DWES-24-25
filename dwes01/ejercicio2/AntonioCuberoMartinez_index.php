<!-- Ponemos unos estilos para que se vea bien la tabla -->
<style>
    table, th, td{
        border: 1px solid black
    }
</style>
<?php
#incluimos el archivo para importar la funcion
require_once('AntonioCuberoMartinez_b.php');

$porcentaje = 70;
#Comprobamos que la variable sea un numero
if (gettype($porcentaje)=='integer'||gettype($porcentaje)=='double') {
    $results = filterArray($porcentaje);
}else{#Si no es un numero usamos esta parte que ejecuta la funcion del archivo b con el valor por defecto que tiene
    $results = filterArray();
}

#Sacamos por pantalla los resultados
echo "<h1>Jugadores cuyo porcentaje de tiro es igual o superior a $porcentaje%</h1>";
echo "<table>
        <tr>
            <th>Año</th>
            <th>Jugador</th>
            <th>Porcentaje de tiro</th>
            <th>Puntuación</th>
        </tr>";
#Con un bucle foreach vamos imprimiendo los valores que hay en el array
foreach ($results as $key => $value) {
    echo "
    <tr>
        <td>{$value['Año']}</td>
        <td>{$value['Jugador']}</td>
        <td>{$value['Porcentaje']}%</td>
        <td>{$value['Puntuacion']}</td>
    </tr>";
}
echo "</table>";