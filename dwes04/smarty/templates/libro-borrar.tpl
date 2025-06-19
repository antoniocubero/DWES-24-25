<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar libro</title>
</head>
<body>
    {* Si no recibimos $aceptar sacamos el formulario *}
    {if !isset($aceptar) && isset($id_borrar)}
    <form action="index.php?accion=borrar_libro_ACM" method="post">
        <label for="aceptar">Marque la casilla para confirmar la eliminacion de el libro</label>
        <input type="checkbox" name="aceptar" value='1'>
        <input type="hidden" name="id_borrar" value="{$id_borrar}">
        <input type="submit" value="Enviar">
    </form>
    {/if}
    {* Si recibimos $id_borrado y $borrado sacamos el id del libro borrado *}
    {if isset($id_borrado) && isset($borrado)}
        {if $borrado == true}
            <h3>Libro con id {$id_borrado} ha sido eliminado</h3>
        {else}{* $borrado no es true sacamos que el libro no existe en la base de datos *}
            <h3>Libro con id {$id_borrado} no existe en la base de datos</h3>
        {/if}
    {/if}
</body>
</html>