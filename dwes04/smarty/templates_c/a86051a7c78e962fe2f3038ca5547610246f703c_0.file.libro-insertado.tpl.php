<?php
/* Smarty version 4.5.5, created on 2025-02-24 16:32:11
  from 'C:\xampp\htdocs\DWES\dwes04\smarty\templates\libro-insertado.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67bc90fb13ef81_38073427',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a86051a7c78e962fe2f3038ca5547610246f703c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\DWES\\dwes04\\smarty\\templates\\libro-insertado.tpl',
      1 => 1740069959,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67bc90fb13ef81_38073427 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro</title>
</head>
<body>
        <?php if ($_smarty_tpl->tpl_vars['errors']->value) {?>
    <h2>Errores:</h2>
    <ul>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors']->value, 'error');
$_smarty_tpl->tpl_vars['error']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['error']->value) {
$_smarty_tpl->tpl_vars['error']->do_else = false;
?>
            <li><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
    <?php }?>

        <?php if ((isset($_smarty_tpl->tpl_vars['id_insertado']->value))) {?>
    <h2>Id del libro insertado: <?php echo $_smarty_tpl->tpl_vars['id_insertado']->value;?>
</h2>
    <?php }?>
</body>
</html><?php }
}
