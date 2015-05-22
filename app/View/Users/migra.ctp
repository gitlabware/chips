<?php debug($datos); ?>
<?php 
    foreach($datos as $d)
    {
        echo h($d['Migralmacen']['id'])." - ";
        echo h($d['Migralmacen']['producto'])."<br />";        
    } 
?>