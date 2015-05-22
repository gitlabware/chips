<div>
    <h3>Datos del usuario</h3>
    <p>
         Nombre: <?php echo $usuario['Persona']['nombre'].' '.$usuario['Persona']['ap_paterno']?>
    </p>
    <p>
        C.I.: <?php echo $usuario['Persona']['ci']?>
    </p>
    <p>
        Tipo de Ususario: <?php echo $usuario['Group']['name']?>
    </p>
    <?php if ($usuario['User']['group_id'] == 5):?>
    <p>
        Tienda: <?php echo $usuario['Sucursal']['nombre']?>
    </p>
    <?php endif;?>
</div>