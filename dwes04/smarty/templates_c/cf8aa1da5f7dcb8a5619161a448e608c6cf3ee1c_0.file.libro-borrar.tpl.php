<?php
/* Smarty version 4.5.5, created on 2025-02-24 16:31:02
  from 'C:\xampp\htdocs\DWES\dwes04\smarty\templates\libro-borrar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67bc90b6339a95_72967644',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cf8aa1da5f7dcb8a5619161a448e608c6cf3ee1c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\DWES\\dwes04\\smarty\\templates\\libro-borrar.tpl',
      1 => 1740069880,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67bc90b6339a95_72967644 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar libro</title>
</head>
<body>
        <?php if (!(isset($_smarty_tpl->tpl_vars['aceptar']->value)) && (isset($_smarty_tpl->tpl_vars['id_borrar']->value))) {?>
    <form action="index.php?accion=borrar_libro_ACM" method="post">
        <label for="aceptar">Marque la casilla para confirmar la eliminacion de el libro</label>
        <input type="checkbox" name="aceptar" value='1'>
        <input type="hidden" name="id_borrar" value="<?php echo $_smarty_tpl->tpl_vars['id_borrar']->value;?>
">
        <input type="submit" value="Enviar">
    </form>
    <?php }?>
        <?php if ((isset($_smarty_tpl->tpl_vars['id_borrado']->value)) && (isset($_smarty_tpl->tpl_vars['borrado']->value))) {?>
        <?php if ($_smarty_tpl->tpl_vars['borrado']->value == true) {?>
            <h3>Libro con id <?php echo $_smarty_tpl->tpl_vars['id_borrado']->value;?>
 ha sido eliminado</h3>
        <?php } else { ?>            <h3>Libro con id <?php echo $_smarty_tpl->tpl_vars['id_borrado']->value;?>
 no existe en la base de datos</h3>
        <?php }?>
    <?php }?>
</body>
</html><?php }
}
