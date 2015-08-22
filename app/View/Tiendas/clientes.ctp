<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Clientes</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="tabla-json">

            <thead>
                <tr>                      

                    <th style="width: 10%;">numero de registro</th>
                    <th >nombre</th>
                    <th style="width: 30%;">direccion</th>  
                    <th >celular</th>
                    <th >zona</th>
                    <th >Acciones</th>
                </tr>
            </thead>          
            <tbody>
                
            </tbody>
        </table>  
    </div>
</section>	

<script>
  urljsontabla = '<?php echo $this->Html->url(array('action' => 'clientes.json')); ?>';
  function asignar(idcliente) {
      location = '<?php echo $this->Html->url(array('action' => 'chips')); ?>/' + idcliente;
  }
  function venta(idcliente) {
      location = '<?php echo $this->Html->url(array('action' => 'formulario')); ?>/' + idcliente;
  }
</script>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/tienda'); ?>
<!-- End sidebar/drop-down menu --> 

