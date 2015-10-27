
<section role="main" id="main">

    <hgroup id="main-title" class="thin">
        <h1>ESTADO ACTUAL</h1>
        <h2> <?php echo date('d-m-Y') ?></h2>
    </hgroup>
    <div class="dashboard">

        <div class="columns">

            <div class="new-row twelve-columns">
                <div id="chart-t-productos" style="min-width: 300px; height: 400px; margin: 0 auto">

                </div>
            </div>
            <div class="new-row twelve-columns">
                <div id="chart-t-celulares" style="min-width: 300px; height: 400px; margin: 0 auto">

                </div>
            </div>
            <div class="new-row twelve-columns">
                <div id="chart-ven-productos" style="min-width: 310px; height: 400px; margin: 0 auto">

                </div>
            </div>
            <div class="new-row twelve-columns">
                <div id="chart-ven-celulares" style="min-width: 310px; height: 400px; margin: 0 auto">

                </div>
            </div>
            <div class="new-row twelve-columns">
                <div id="chart-cajas" style="min-width: 300px; height: 400px; margin: 0 auto">

                </div>
            </div>
            <div class="new-row twelve-columns">
                <div id="chart-ingresos" style="min-width: 310px; height: 400px; margin: 0 auto">

                </div>
            </div>
        </div>
    </div>
    <div class="with-padding">                   

    </div>
</section>	
<?php echo $this->element('sidebar/administrador'); ?>
<?= $this->Html->script(array('highcharts', 'exporting', 'dark-green')); ?>
<script type="text/javascript">
  //----------- Para productos -------//
  var miscategorias = [
<?php foreach ($productos_1 as $pro): ?>
    '<?= $pro['Producto']['nombre'] ?>',
<?php endforeach; ?>
  ];
          var misseries = [
<?php foreach ($almacenes_1 as $al): ?>
            {
            name: '<?= $al['Almacene']['nombre'] ?>',
                    data: [
  <?php foreach ($productos_1 as $pro): ?>
    <?= $this->requestAction(array('action' => 'get_total', $pro['Producto']['id'], 1, $al['Almacene']['id'])) ?>,
  <?php endforeach; ?>
                    ]
            },
<?php endforeach; ?>
          ];
//---------- Termina Para productos ------//

          //----------- Ventas Para productos -------//
          var miscategorias3 = [
<?php foreach ($productos_1 as $pro): ?>
            '<?= $pro['Producto']['nombre'] ?>',
<?php endforeach; ?>
          ];
          var misseries3 = [
<?php foreach ($almacenes_3 as $al): ?>
            {
            name: '<?= $al['Almacene']['nombre'] ?>',
                    data: [
  <?php foreach ($productos_1 as $pro): ?>
    <?= $this->requestAction(array('action' => 'get_ventat_pro_alm', $al['Almacene']['id'], $pro['Producto']['id'])) ?>,
  <?php endforeach; ?>
                    ]
            },
<?php endforeach; ?>
          ];
//---------- Termina Ventas Para productos ------//

          //----------- Para Celulares -------//
          var miscategorias2 = [
<?php foreach ($productos_2 as $pro): ?>
            '<?= $pro['Producto']['nombre'] ?>',
<?php endforeach; ?>
          ];
          var misseries2 = [
<?php foreach ($almacenes_1 as $al): ?>
            {
            name: '<?= $al['Almacene']['nombre'] ?>',
                    data: [
  <?php foreach ($productos_2 as $pro): ?>
    <?= $this->requestAction(array('action' => 'get_total', $pro['Producto']['id'], 1, $al['Almacene']['id'])) ?>,
  <?php endforeach; ?>
                    ]
            },
<?php endforeach; ?>
          ];
//---------- Termina Para Celulares ------//


//----------- Ventas Para Celulares -------//
          var miscategorias4 = [
<?php foreach ($productos_2 as $pro): ?>
            '<?= $pro['Producto']['nombre'] ?>',
<?php endforeach; ?>
          ];
          var misseries4 = [
<?php foreach ($almacenes_3 as $al): ?>
            {
            name: '<?= $al['Almacene']['nombre'] ?>',
                    data: [
  <?php foreach ($productos_2 as $pro): ?>
    <?= $this->requestAction(array('action' => 'get_ventat_cel_alm', $al['Almacene']['id'], $pro['Producto']['id'])) ?>,
  <?php endforeach; ?>
                    ]
            },
<?php endforeach; ?>
          ];
//---------- Termina Ventas Para Celulares ------//

          $(function () {
          $('#chart-t-productos').highcharts({
          chart: {
          type: 'column'
          },
                  title: {
                  text: 'Cantidad Actual de Productos Por Tienda'
                  },
                  xAxis: {
                  categories: miscategorias
                  },
                  yAxis: {
                  min: 0,
                          title: {
                          text: 'Total en almacen'
                          },
                          stackLabels: {
                          enabled: true,
                                  style: {
                                  fontWeight: 'bold',
                                          color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                                  }
                          }
                  },
                  legend: {
                  align: 'right',
                          x: - 30,
                          verticalAlign: 'top',
                          y: 25,
                          floating: true,
                          backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                          borderColor: '#CCC',
                          borderWidth: 1,
                          shadow: false
                  },
                  tooltip: {
                  headerFormat: '<b>{point.x}</b><br/>',
                          pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                  },
                  plotOptions: {
                  column: {
                  stacking: 'normal',
                          dataLabels: {
                          enabled: true,
                                  color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                                  style: {
                                  textShadow: '0 0 3px black'
                                  }
                          }
                  }
                  },
                  series: misseries
          });
          });
          $(function () {
          $('#chart-t-celulares').highcharts({
          chart: {
          type: 'column'
          },
                  title: {
                  text: 'Cantidad Actual de Celulares Por Tienda'
                  },
                  xAxis: {
                  categories: miscategorias2

                  },
                  yAxis: {
                  min: 0,
                          title: {
                          text: 'Total en almacen'
                          },
                          stackLabels: {
                          enabled: true,
                                  style: {
                                  fontWeight: 'bold',
                                          color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                                  }
                          }
                  },
                  legend: {
                  align: 'right',
                          x: - 30,
                          verticalAlign: 'top',
                          y: 25,
                          floating: true,
                          backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                          borderColor: '#CCC',
                          borderWidth: 1,
                          shadow: false
                  },
                  tooltip: {
                  headerFormat: '<b>{point.x}</b><br/>',
                          pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                  },
                  plotOptions: {
                  column: {
                  stacking: 'normal',
                          dataLabels: {
                          enabled: true,
                                  color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                                  style: {
                                  textShadow: '0 0 3px black'
                                  }
                          }
                  }
                  },
                  series: misseries2
          });
          });
          $(function () {
          $('#chart-ven-productos').highcharts({
          chart: {
          type: 'bar'
          },
                  title: {
                  text: 'Ventas de Productos - Hoy <?= date('d/m/Y') ?>'
                  },
                  xAxis: {
                  categories: miscategorias3
                  },
                  yAxis: {
                  allowDecimals: false,
                          min: 0,
                          title: {
                          text: 'Cantidad Total'
                          }
                  },
                  legend: {
                  reversed: true
                  },
                  plotOptions: {
                  series: {
                  stacking: 'normal'
                  }
                  },
                  series: misseries3
          });
          });
          $(function () {
          $('#chart-ven-celulares').highcharts({
          chart: {
          type: 'bar'
          },
                  title: {
                  text: 'Ventas de Celulares - Hoy <?= date('d/m/Y') ?>'
                  },
                  xAxis: {
                  categories: miscategorias4
                  },
                  yAxis: {
                  allowDecimals: false,
                          min: 0,
                          title: {
                          text: 'Cantidad Total'
                          }
                  },
                  legend: {
                  reversed: true
                  },
                  plotOptions: {
                  series: {
                  stacking: 'normal'
                  }
                  },
                  series: misseries4
          });
          });
// ---------- Chart para Efectivo --------//
          var misdatos = [
<?php foreach ($almacenes_3 as $al): ?>
            ['<?= $al['Almacene']['nombre'] ?>',<?= $this->requestAction(array('controller' => 'Tiendas', 'action' => 'get_total_caja', $al['Almacene']['sucursal_id'])) ?>],
<?php endforeach; ?>
          ];
          $(function () {
          $('#chart-cajas').highcharts({
          chart: {
          type: 'column'
          },
                  title: {
                  text: 'Efectivo Actual por Tienda'
                  },
                  xAxis: {
                  type: 'category',
                          labels: {
                          rotation: - 45,
                                  style: {
                                  fontSize: '13px',
                                          fontFamily: 'Verdana, sans-serif'
                                  }
                          }
                  },
                  yAxis: {
                  labels: {
                  formatter: function() {
                  return this.value;
                  }
                  },
                          min: 0,
                          title: {
                          text: 'Efectivo (Bolivianos)'
                          }
                  },
                  legend: {
                  enabled: false
                  },
                  tooltip: {
                  pointFormat: 'Efectivo actual: <b>{point.y:.1f} Bolivianos</b>'
                  },
                  series: [{
                  name: 'Efectivo',
                          data: misdatos,
                          dataLabels: {
                          enabled: true,
                                  rotation: - 90,
                                  color: '#FFFFFF',
                                  align: 'right',
                                  format: '{point.y:.1f}', // one decimal
                                  y: 10, // 10 pixels down from the top
                                  style: {
                                  fontSize: '13px',
                                          fontFamily: 'Verdana, sans-serif'
                                  }
                          }
                  }]
          });
          });
          var misseries6 = [
<?php foreach ($almacenes_3 as $al): ?>
  <?php $ingresos_caja = $this->requestAction(array('controller' => 'Tiendas', 'action' => 'get_ingresos_caja', $al['Almacene']['sucursal_id'], $fecha_inicial, $fecha_final)); ?>
            {
            name: "<?= $al['Almacene']['nombre'] ?>",
                    data: [
  <?php foreach ($ingresos_caja as $ing): ?>
                      [Date.UTC(<?= $ing[0]['ano'] ?>, <?= $ing[0]['mes'] - 1 ?>, <?= $ing[0]['dia'] ?>), <?= $ing[0]['monto_total'] ?>],
  <?php endforeach; ?>
                    ]
            },
<?php endforeach; ?>
          ];
          $(function () {
          $('#chart-ingresos').highcharts({
          chart: {
          type: 'spline'
          },
                  title: {
                  text: 'Ingresos de efectivo del Mes'
                  },
                  xAxis: {
                  type: 'datetime',
                          dateTimeLabelFormats: { // don't display the dummy year
                          month: '%e. %b',
                                  year: '%b'
                          },
                          title: {
                          text: 'Fecha'
                          }
                  },
                  yAxis: {
                  labels: {
                  formatter: function() {
                  return this.value;
                  }
                  },
                          title: {
                          text: 'Monto de efectivo'
                          },
                          min: 0
                  },
                  tooltip: {
                  headerFormat: '<b>{series.name}</b><br>',
                          pointFormat: '{point.x:%e. %b}: {point.y:.2f} Bs'
                  },
                  plotOptions: {
                  spline: {
                  marker: {
                  enabled: true
                  }
                  }
                  },
                  series: misseries6
          });
          });
</script>
