<?php
/* Smarty version 4.5.5, created on 2025-02-24 16:31:40
  from 'C:\xampp\htdocs\DWES\dwes04\smarty\templates\form-libro-nuevo.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.5.5',
  'unifunc' => 'content_67bc90dc9be024_22057612',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ca0b3bac3817fa0e19ec0a546dced558b1702b6' => 
    array (
      0 => 'C:\\xampp\\htdocs\\DWES\\dwes04\\smarty\\templates\\form-libro-nuevo.tpl',
      1 => 1740069979,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67bc90dc9be024_22057612 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
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
</html><?php }
}
