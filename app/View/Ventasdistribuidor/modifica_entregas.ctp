<div class="with-padding">
    <?php echo $this->Form->create('Productosprecio', array('action' => 'registra_precio', 'id' => 'form_precio')); ?>
    <div class="columns">

        <div class="new-row ten-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label">Para <small>(requerido)</small></label> 
                <?php echo $this->Form->hidden('producto_id', array('value' => $idProducto)) ?>
                <?php echo $this->Form->select('tipousuario_id', $clie, array('class' => 'select full-width')); ?>
            </p>
        </div>
        <div class="twelve-columns">
            <p class="block-label button-height">
                <a href="javascript:" class="button green-gradient full-width" onclick="registra_precio();">REGISTRAR</a>
            </p>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

<script>
<?php if (count($precios) == 0): ?>
    $('#idproducto-<?php echo $idProducto ?>').addClass('red-bg');
    $('#idproducto-<?php echo $idProducto ?>').html('<?php echo count($precios);?>');
<?php else: ?>
    $('#idproducto-<?php echo $idProducto ?>').removeClass('red-bg');
    $('#idproducto-<?php echo $idProducto ?>').html('<?php echo count($precios);?>');
<?php endif; ?>
  function registra_precio() {
      var postData = $('#form_precio').serializeArray();
      var formURL = $('#form_precio').attr("action");
      $.ajax(
              {
                  url: formURL,
                  type: "POST",
                  data: postData,
                  /*beforeSend:function (XMLHttpRequest) {
                   alert("antes de enviar");
                   },
                   complete:function (XMLHttpRequest, textStatus) {
                   alert('despues de enviar');
                   },*/
                  success: function (data, textStatus, jqXHR)
                  {
                      if ($.parseJSON(data).correcto != '') {
                          mensaje_nota('Excelente!!', $.parseJSON(data).correcto);
                      } else {
                          mensaje_nota('Error!!', 'No se registro el precio!!');
                      }

                      $('#idmodal').load('<?php echo $this->Html->url(array('controller' => 'Productosprecios', 'action' => 'ajax_precios', $idProducto)); ?>');
                      //data: return data from server
                      //$("#parte").html(data);
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      //if fails   
                      alert("error");
                  }
              });
  }
  function quita_precio(idprecio) {
      if (confirm('Esta seguro de quitar el precio??')) {

          $("#idmodal").load("<?php echo $this->Html->url(array('controller' => 'Productosprecios', 'action' => 'quita_precio')); ?>/" + idprecio + "/<?php echo $idProducto; ?>", function (responseTxt, statusTxt, xhr) {
              if ($.parseJSON(responseTxt).correcto != '') {
                  mensaje_nota('Excelente!!', $.parseJSON(responseTxt).correcto);
              } else {
                  mensaje_nota('Error!!', 'No se registro el precio!!');
              }
              $('#idmodal').load('<?php echo $this->Html->url(array('controller' => 'Productosprecios', 'action' => 'ajax_precios', $idProducto)); ?>');
              if (statusTxt == "error")
                  alert("Error: " + xhr.status + ": " + xhr.statusText);
          });
      }
  }

</script>