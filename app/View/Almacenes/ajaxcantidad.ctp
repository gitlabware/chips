<p>
    <b style="color: #F00;">
    <?php if ($almacen != 1):?>
    <?php if($cantidad != null):?>
        La cantidad en almacen es: <?php echo $cantidad;?>
    <?php else:?>
        No hay en Almacen
    <?php endif;?>
    <?php endif;?>
    </b>
</p>