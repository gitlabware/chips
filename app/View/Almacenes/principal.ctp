
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/styles/dashboard.css?v=1">
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>ESTADO ACTUAL</h1>
        <h2> <?php echo date('d-m-Y') ?></h2>
    </hgroup>
    <div class="dashboard">

        <div class="columns">

            <div class="nine-columns twelve-columns-mobile" id="demo-chart">
                <!-- This div will hold the chart generated in the footer -->
            </div>
            <div class="three-columns twelve-columns-mobile new-row-mobile">
                <ul class="stats split-on-mobile">
                    <?php foreach ($productos as $pro): ?>
                      <li>
                          <strong><?php
                              if (empty($pro['Producto']['total_central'])) {
                                echo 0;
                              } else {
                                echo $pro['Producto']['total_central'];
                              }
                              ?></strong><?php echo $pro['Producto']['nombre'] ?>
                      </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="with-padding">                   

    </div>
</section>	
<?php echo $this->element('sidebar/administrador'); ?>
<?php echo $this->Html->script(array('http://www.google.com/jsapi', 'iniprincipal'), array('block' => 'js_add')); ?>
<script>
  var datos_est = [
<?php foreach ($productos as $pro): ?>
        ['<?php echo $pro['Producto']['nombre']; ?>'
  <?php foreach ($meses as $me): ?>
          , <?php echo $this->requestAction(array('action' => 'get_vent_mes', $pro['Producto']['id'], $me[0]['mes'])); ?>
  <?php endforeach; ?>
    ]
    ,
<?php endforeach; ?>
  ];
          var meses = [
<?php foreach ($meses as $me): ?>
                '<?php echo $me[0]['nombre']; ?>',
<?php endforeach; ?>
          ];

</script>