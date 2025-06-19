<?php if (isset($errors) && is_array($errors) && count($errors)>0): ?>
<h2>Errores (<?=count($errors)?>)</h2>
<ul>
    <?php 
        array_walk($errors,function($e){echo "<LI>$e</LI>";});
    ?>
</ul>
<?php endif; ?>

<?php if (isset($notifs) && is_array($notifs) && count($notifs)>0): ?>
<h2>Notificaciones (<?=count($notifs)?>)</h2>
<ul>
    <?php 
        array_walk($notifs,function($n){echo "<LI>$n</LI>";});
    ?>
</ul>
<?php endif; ?>