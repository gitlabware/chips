<div >
    <p >
    <label  class="label">
       <b>Producto</b> 
    </label>

    <select  name="data[Recargascabina][producto_id]" class="select  validate[required]"  >

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

