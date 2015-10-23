<div>
<?php //debug($usuarios2);exit;?>
<?php foreach($usuarios2 as $u):?>
<p>
    <b>Usuario: <?php echo $u['Persona']['nombre'].' '.$u['Persona']['ap_paterno'];?></b>
</p>
<?php endforeach;?>
</div>