<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro</title>
</head>
<body>
    {* Si hay errores los sacamos *}
    {if $errors}
    <h2>Errores:</h2>
    <ul>
        {foreach from=$errors item=error}
            <li>{$error}</li>
        {/foreach}
    </ul>
    {/if}

    {* Si se inserto recibiremos $id_insertado, y lo sacamos *}
    {if isset($id_insertado)}
    <h2>Id del libro insertado: {$id_insertado}</h2>
    {/if}
</body>
</html>