<?php
$meses = array(
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Sepetiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Disciembre'
);
?>

<h3 class="thin underline">Comision <?php echo $meses[(int) $this->request->data['Comisione']['mes']] . '-' . $this->request->data['Comisione']['gestion']; ?></h3>
<?php echo $this->Form->create('Comision', array( 'id' => 'form_precio')); ?>

<div class="columns">

    <div class="twelve-columns twelve-columns-mobile">
        <p class="block-label button-height">
            <label for="block-label-1" class="label">Cliente <?php echo $this->request->data['Cliente']['num_registro'] ?></label>                    
            <?php echo $this->Form->text('Cliente.nombre', array('class' => 'input full-width', 'disabled')); ?>
        </p>
    </div>
    <div class="six-columns six-columns-mobile">
        <p class="block-label button-height">
            <label for="block-label-1" class="label">Monto</label>                    
            <?php echo $this->Form->text('Comisione.monto_a_pagar', array('class' => 'input full-width', 'type' => 'number', 'step' => 'any', 'disabled')); ?>
        </p>
    </div>
    <div class="six-columns six-columns-mobile">
        <p class="block-label button-height">
            <label for="block-label-1" class="label">Descuento</label>                    
            <?php echo $this->Form->text('Comisione.descuento', array('class' => 'input full-width', 'type' => 'number', 'step' => 'any', 'disabled', 'value' => round(($this->request->data['Comisione']['monto_a_pagar'] * 0.16), 2))); ?>
        </p>
    </div>
    <div class=" six-columns twelve-columns-mobile">
        <p class="button-height">
            Pagado
            <?php echo $this->Form->checkbox('Comisione.pagado', array('class' => 'switch medium wide anthracite-active mid-margin-left pagado', 'data-text-on' => 'SI', 'data-text-off' => 'NO')) ?>
        </p>
    </div>
    <div class="six-columns twelve-columns-mobile">
        <p class="button-height" id="ppf">
            Factura
            <?php echo $this->Form->checkbox('Comisione.factura', array('class' => 'switch medium wide anthracite-active mid-margin-left factura', 'data-text-on' => 'SI', 'data-text-off' => 'NO', 'id' => 'idfactura')) ?>
        </p>
    </div>
    <div class="six-columns six-columns-mobile">
        <p class="block-label button-height">
            <label for="block-label-1" class="label">Monto a pagar</label>                    
            <?php echo $this->Form->text('Comisione.tttt', array('class' => 'input full-width', 'type' => 'number', 'step' => 'any', 'disabled', 'id' => 'montotal')); ?>
        </p>
    </div>
    <div class="six-columns six-columns-mobile">
        <p class="block-label button-height">
            <label for="block-label-1" class="label">Aumento</label>                    
            <?php echo $this->Form->text('Comisione.aumento', array('class' => 'input full-width', 'placeholder' => 'Ingrese el aumento', 'type' => 'number', 'step' => 'any')); ?>
        </p>
    </div>
    <div class="twelve-columns twelve-columns-mobile">
        <p class="block-label button-height">
            <label class="label">&nbsp;</label>  
            <?php echo $this->Form->submit('REGISTRAR',array('class' => 'button green-gradient full-width'));?>
        </p>
    </div>
</div>
<?php echo $this->Form->end(); ?>
<script>

    var monto = <?php echo $this->request->data['Comisione']['monto_a_pagar'] ?>;

    (function ($, window, document, undefined)
    {
        $.template.addSetupFunction(function (self, children)
        {

            if ($('span.factura').hasClass('checked')) {
                $('#montotal').val(monto);
            } else {
                $('#montotal').val(monto - (monto * 0.16));
            }
            function calcular_monto() {
                if (!$('span.factura').hasClass('checked')) {
                    $('#montotal').val(Math.round(monto * 100) / 100);
                } else {
                    $('#montotal').val(Math.round((monto - (monto * 0.16)) * 100) / 100);
                }
            }
            $('span.factura').on('change', function () {
                calcular_monto();
            });
        });
    })(jQuery, window, document);
</script>