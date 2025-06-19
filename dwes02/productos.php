<?php

//Añadimos los archivos necesarios
include_once('etc/conf.php');
include_once('funciones/getProducts.php');


function showProducts($conn){
    include_once('etc/conf.php');
    //$validCategories = ['lacteos', 'conservas', 'bebidas', 'snacks', 'dulces', 'otros']; //Eliminar la linea anterior y descomentar esta si no funciona

    //Comprobamos que se han pasado categorias y son correctas, si no usamos la funcion con un parametro y usa el valor null en $cat
    if (isset($_POST['categorie']) && in_array($_POST['categorie'],VALID_CATEGORIES)) {
        $results = getProducts($conn,$_POST['categorie']);
    }else{
        $results = getProducts($conn);
    }

    //Comprobamos que se ha usado bien la funcion getProducts
    if ($results) {
        //Sacamos el formulario para poder filtrar
        echo "<form action='".$_SERVER["PHP_SELF"]."' method='post'>
                <select name='categorie'>
                    <option value='lacteos'>Lacteos</option>
                    <option value='conservas'>Conservas</option>
                    <option value='bebidas'>Bebidas</option>
                    <option value='snacks'>Snack</option>
                    <option value='dulces'>Dulces</option>
                    <option value='otros'>Otros</option>
                </select>
                <input type='submit' value='Seleccionar'>
            </form>";

        //Imprimimos los estilos y el principio de la tabla
        echo "<style>
                th, td{
                    min-width: 75px;
                }
                td{
                    height: 75px;
                }
            </style>";
        echo "<table border=1>";
        echo "<tr><th>Nombre</th><th>Código EAN</th><th>Categoria</th><th>Propiedades</th><th>Unidades</th><th>Precio</th><th>Operaciones</th></tr>";
        //Usamos un bucle for each para sacar cada producto que existe en la base de datos
        foreach ($results as $v) {
            echo "<tr>";
            echo '<td>' . htmlspecialchars($v['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($v['codigo_ean']) . '</td>';
            echo '<td>' . htmlspecialchars($v['categoria']) . '</td>';
            if ($v['propiedades']==null) {//Comprobamos si las propiedades son null y si es asi ponemos No descritas
                echo '<td>No descritas</td>';
            }else{
                //Si existen, usamos explode para crear un array de las propiedades
                $arr = explode(",", $v['propiedades']);
                echo '<td><ul>';
                //Recorremos las propiedades y las sacamos en forma de lista
                foreach ($arr as $key2 => $value2) {
                    echo "<li>$value2</li>";
                }
                echo '</ul></td>';
                //echo '<td>' . htmlspecialchars($v['propiedades']) . '</td>';
            }
            echo '<td>' . htmlspecialchars($v['unidades']) . '</td>';
            echo '<td>' . htmlspecialchars($v['precio']) . '</td>'; 
            //Creacion de los botones de modificar y eliminar
            echo '<td>' . 
                    '<form action="modificarproducto.php" method="post">
                            <label for="amount">Incremento o decremento</label>
                            <input type="text" name="amount">
                            <input type="hidden" name="id" value='.htmlspecialchars($v['id']).'>
                            <input type="submit" value="Modificar">
                    </form>
                    <form action="eliminar.php" method="post">
                            <input type="hidden" name="id" value='.htmlspecialchars($v['id']).'>
                            <input type="submit" value="Eliminar">
                    </form>
                    </td>';
            echo "</tr>";
        }
        echo "</table>";
    }else{
        //Si fallase la funcion mostraria esta parte
        echo 'Ha ocurrido un error';
    }

};

//Ejecutamos la funcion
showProducts($conn);