<div id="select2">
</div>
<div>
<p class="button-height inline-label">
    <label for="validation-select" class="label">
        Productos
    </label>

    <select id="select1" name="data[Movimiento][producto_id]" class="select expandable-list anthracite-gradient glossy validate[required]" tabindex="2">

        <option value="">
            Seleccione un producto
        </option>
        <?php foreach ($productos as $producto): ?>
            <option value="<?php echo $producto['Producto']['id'] ?>">
                <?php echo $producto['Producto']['nombre'] . ' ' . $producto['Producto']['proveedor'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</p>
</div>
<script>
    $(document).ready(function() {

        $("#select1").change(function() {
            
            $('#select2').load('<?php echo $this->Html->url(array('action' => 'ajaxcantidad')) ?>/'+this.value+'/<?php echo $almacen;?>');
        });
    });
</script>