<?php
/* Smarty version 4.5.5, created on 2025-02-18 20:44:12
  from 'C:\xampp\htdocs\DWES\dwes04\smarty\templates\salida.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67b4e30c87eff0_63755380',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b6a192c78c6f54a51e4490545cb7da8821ab1e57' => 
    array (
      0 => 'C:\\xampp\\htdocs\\DWES\\dwes04\\smarty\\templates\\salida.tpl',
      1 => 1739907833,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67b4e30c87eff0_63755380 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
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
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['libros']->value, 'libro');
$_smarty_tpl->tpl_vars['libro']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['libro']->value) {
$_smarty_tpl->tpl_vars['libro']->do_else = false;
?>
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getId();?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getTitulo();?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getAutor();?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getIsbn();?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getAnioPublicacion();?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getPaginas();?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getEjemplaresDisponibles();?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getFechaCreacion();?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['libro']->value->getFechaActualizacion();?>
</td>
                    <td>
                        <form action="index.php?accion=borrar_libro_ACM" method="post">
                            <input type="hidden" name="id_borrar" value="<?php echo $_smarty_tpl->tpl_vars['libro']->value->getId();?>
">
                            <input type="submit" value="Borrar">
                        </form>
                    </td>
                </tr>
            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
    <br>
    <form action="" method="post">
        <label for="orden">Ordenar la tabla:</label>
        <select name="orden">
            <option value="true">Fecha de creación</option>
            <option value="false">Fecha de actualización</option>
        </select>
        <input type="submit" value="Ordenar tabla">
    </form>
</body>
</html><?php }
}
