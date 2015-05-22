<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <?php
        
        if($es_almacen == '1'){
          echo '<h1>Entrega a Tienda '.$almacen['Sucursal']['nombre'].'</h1>';
        }
        ?>
    </hgroup>
    <div class="with-padding">                   
        <table class="table responsive-table" id="tabla-json">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>          
            <tbody>
                
            </tbody>
        </table>  
    </div>
</section>	

<script>
  urljsontabla = '<?php echo $this->Html->url(array('action' => "entrega_celulares/$id_a/$es_almacen.json")); ?>';
  function add(id_celular) {
      cargarmodal('<?php echo $this->Html->url(array('action' => 'ajax_entrega_cel',$id_a));?>/1/'+id_celular,'ENTREGA DE PRODUCTO');
  }
</script>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 

