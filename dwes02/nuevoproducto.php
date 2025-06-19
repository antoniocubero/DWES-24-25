<?php
if (isset($okData['cat'])) {//Comprobamos que las categorias estan bien
    ${'categoria'.htmlspecialchars($okData['cat'], ENT_QUOTES, 'UTF-8')} = 'selected';//Creamos una variable con el nombre categoria mas el nombre de la categoria y le guardamos el valor selected
}
if(isset($_POST['prop'])){
    foreach ($_POST['prop'] as $value) {
        ${'propiedad'.str_replace(' ', '', htmlspecialchars($value, ENT_QUOTES, 'UTF-8'))} = 'checked';//Usamos el str_replace para eliminar los espacios en las propiedades que las tengan, como sin lactosa
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="guardarproducto.php" method="post">
        <label for="name">Nombre:</label>
        <input type="text" name="name" value='<?= htmlspecialchars($okData["name"] ?? "", ENT_QUOTES, "UTF-8") ?? "" ?>'> <br><!-- Reinyectamos el valor del nombre si es correcto si no lo dejamos en blanco -->

        <label for="ean">Código EAN:</label>
        <input type="text" name="ean" value='<?= htmlspecialchars($okData["ean"] ?? "", ENT_QUOTES, "UTF-8") ?>'> <br>

        <label for="cat">Categoría:</label>
        <select name="cat">
            <option value='lacteos' <?=$categorialacteos ?? "" ?>>Lacteos</option><!-- Tanto en los select como en los checkbox sacamos si esta selected (en el caso de los select) o checked (en los checkboxes) y si no pues lo dejamos en blanco -->
            <option value='conservas' <?=$categoriaconservas ?? "" ?>>Conservas</option>
            <option value='bebidas' <?=$categoriabebidas ?? "" ?>>Bebidas</option>
            <option value='snacks' <?=$categoriasnacks ?? "" ?>>Snack</option>
            <option value='dulces' <?=$categoriadulces ?? "" ?>>Dulces</option>
            <option value='otros' <?=$categoriaotros ?? "" ?>>Otros</option>
        </select> <br>

        <span>Propiedades:</span>
        <input type="checkbox" name="prop[]" <?=$propiedadsingluten ?? "" ?> value="sin gluten"><label for="sin gluten">Sin gluten</label>
        <input type="checkbox" name="prop[]" <?=$propiedadsinlactosa ?? "" ?> value="sin lactosa"><label for="sin lactosa">Sin lactosa</label>
        <input type="checkbox" name="prop[]" <?=$propiedadvegano ?? "" ?> value="vegano"><label for="vegano">Vegano</label>
        <input type="checkbox" name="prop[]" <?=$propiedadorgánico ?? "" ?> value="orgánico"><label for="orgánico">Orgánico</label>
        <input type="checkbox" name="prop[]" <?=$propiedadsinconservantes ?? "" ?> value="sin conservantes"><label for="sin conservantes">Sin conservantes</label>
        <input type="checkbox" name="prop[]" <?=$propiedadsincolorantes ?? "" ?> value="sin colorantes"><label for="sin colorantes">Sin colorantes</label>
        <input type="checkbox" name="prop[]" <?=$propiedadtest ?? "" ?> value="test"><label for="test">TEST</label> <br>

        <label for="unit">Unidades:</label>
        <input type="text" name="unit" value='<?= htmlspecialchars($okData["unit"] ?? "", ENT_QUOTES, "UTF-8") ?>'> <br>
        <label for="price">Precio:</label>
        <input type="text" name="price" value='<?= htmlspecialchars($okData["price"] ?? "", ENT_QUOTES, "UTF-8") ?>'> <br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>