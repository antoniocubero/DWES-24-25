<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de libros</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th><th>Titulo</th><th>Autor</th><th>ISBN</th><th>Año de publicación</th><th>Páginas</th><th>Ejemplares disponibles</th><th>Fecha de creación</th><th>Fecha de actualización</th><th>Borrar</th>
            </tr>
        </thead>
        <tbody>
        {* Imprimimos la tabla con los valores de cada libro almacenado en $libros *}
            {foreach $libros as $libro}
                <tr>
                    <td>{$libro->getId()}</td>
                    <td>{$libro->getTitulo()}</td>
                    <td>{$libro->getAutor()}</td>
                    <td>{$libro->getIsbn()}</td>
                    <td>{$libro->getAnioPublicacion()}</td>
                    <td>{$libro->getPaginas()}</td>
                    <td>{$libro->getEjemplaresDisponibles()}</td>
                    <td>{$libro->getFechaCreacion()}</td>
                    <td>{$libro->getFechaActualizacion()}</td>
                    <td>{* Sacamos un formulario con un input hidden con el id del libro para poder borrarlo *}
                        <form action="index.php?accion=borrar_libro_ACM" method="post">
                            <input type="hidden" name="id_borrar" value="{$libro->getId()}">
                            <input type="submit" value="Borrar">
                        </form>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
    <br>
    {* Sacamos el form para ordenar *}
    <form action="index.php" method="post">
        <label for="orden">Ordenar la tabla:</label>
        <select name="orden">
            <option value="true">Fecha de creación</option>
            <option value="false">Fecha de actualización</option>
        </select>
        <input type="submit" value="Ordenar tabla">
    </form>
</body>
</html>