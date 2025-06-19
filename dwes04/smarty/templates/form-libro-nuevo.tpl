<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario libro nuevo</title>
    <style>
        form div{
            display: flex;
            flex-direction: column;
            width: 200px;
        }
    </style>
</head>
<body>
    {* Formulario para insertar un libro nuevo *}
    <form action="index.php?accion=crear_libro_ACM" method="post">
        <h3>Nuevo Libro</h3>
        <div>
            <label for="titulo">Titulo:</label>
            <input type="text" name="titulo">
            <label for="autor">Autor:</label>
            <input type="text" name="autor">
            <label for="isbn">ISBN:</label>
            <input type="text" name="isbn">
            <label for="anio">Año de publicación:</label>
            <input type="text" name="anio">
            <label for="paginas">Paginas:</label>
            <input type="text" name="paginas">
            <label for="ejemplares">Ejemplares disponibles:</label>
            <input type="text" name="ejemplares">
        </div>
        <br>
        <input type="submit" value="Añadir">
    </form>
</body>
</html>