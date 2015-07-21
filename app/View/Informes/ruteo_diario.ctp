<style type="text/css" media="print">
    @page {
        size: letter landscape;
        margin: 0;
    }
    .no-imprime{
        display: none !important;
    }
    *{
        margin: 0px !important;
        padding: 0px !important;
    }
    .printable{
        background-color: white !important;
        padding: 13px !important;
        width: 950px !important;
        height: 554pt !important;
        margin-left: 5px !important;
    }

    .cabecera{
        width: 100% !important; 
        color: black !important;
        margin-bottom: 10px !important;
    }

    .estados1{
        width: 100% !important;
        margin-top: 10px !important;
    }

    .tabla1{
        margin-top: 10px !important;
    }

    .CSSTableGenerator {
        margin:0px;padding:0px;
        width:100%;
        border:1px solid #000000;

        -moz-border-radius-bottomleft:0px;
        -webkit-border-bottom-left-radius:0px;
        border-bottom-left-radius:0px;

        -moz-border-radius-bottomright:0px;
        -webkit-border-bottom-right-radius:0px;
        border-bottom-right-radius:0px;

        -moz-border-radius-topright:0px;
        -webkit-border-top-right-radius:0px;
        border-top-right-radius:0px;

        -moz-border-radius-topleft:0px;
        -webkit-border-top-left-radius:0px;
        border-top-left-radius:0px;
    }.CSSTableGenerator table{
        border-collapse: collapse;
        border-spacing: 0;
        width:100%;
        height:100%;
        margin:0px;padding:0px;
    }.CSSTableGenerator tr:last-child td:last-child {
        -moz-border-radius-bottomright:0px;
        -webkit-border-bottom-right-radius:0px;
        border-bottom-right-radius:0px;
    }
    .CSSTableGenerator table tr:first-child td:first-child {
        -moz-border-radius-topleft:0px;
        -webkit-border-top-left-radius:0px;
        border-top-left-radius:0px;
    }
    .CSSTableGenerator table tr:first-child td:last-child {
        -moz-border-radius-topright:0px;
        -webkit-border-top-right-radius:0px;
        border-top-right-radius:0px;
    }.CSSTableGenerator tr:last-child td:first-child{
        -moz-border-radius-bottomleft:0px;
        -webkit-border-bottom-left-radius:0px;
        border-bottom-left-radius:0px;
    }.CSSTableGenerator tr:hover td{
        background-color:#ffffff;


    }
    .CSSTableGenerator td{
        vertical-align:middle;

        background-color:#ffffff;

        border:1px solid #000000;
        border-width:0px 1px 1px 0px;
        padding:1px;
        font-size:9px !important;
        font-family:Arial;
        font-weight:bold;
        color:#000000;
    }.CSSTableGenerator tr:last-child td{
        border-width:0px 1px 0px 0px;
    }.CSSTableGenerator tr td:last-child{
        border-width:0px 0px 1px 0px;
    }.CSSTableGenerator tr:last-child td:last-child{
        border-width:0px 0px 0px 0px;
    }
</style>
<style>

    .CSSTableGenerator {
        margin:0px;padding:0px;
        width:100%;
        border:1px solid #000000;

        -moz-border-radius-bottomleft:0px;
        -webkit-border-bottom-left-radius:0px;
        border-bottom-left-radius:0px;

        -moz-border-radius-bottomright:0px;
        -webkit-border-bottom-right-radius:0px;
        border-bottom-right-radius:0px;

        -moz-border-radius-topright:0px;
        -webkit-border-top-right-radius:0px;
        border-top-right-radius:0px;

        -moz-border-radius-topleft:0px;
        -webkit-border-top-left-radius:0px;
        border-top-left-radius:0px;
    }.CSSTableGenerator table{
        border-collapse: collapse;
        border-spacing: 0;
        width:100%;
        height:100%;
        margin:0px;padding:0px;
    }.CSSTableGenerator tr:last-child td:last-child {
        -moz-border-radius-bottomright:0px;
        -webkit-border-bottom-right-radius:0px;
        border-bottom-right-radius:0px;
    }
    .CSSTableGenerator table tr:first-child td:first-child {
        -moz-border-radius-topleft:0px;
        -webkit-border-top-left-radius:0px;
        border-top-left-radius:0px;
    }
    .CSSTableGenerator table tr:first-child td:last-child {
        -moz-border-radius-topright:0px;
        -webkit-border-top-right-radius:0px;
        border-top-right-radius:0px;
    }.CSSTableGenerator tr:last-child td:first-child{
        -moz-border-radius-bottomleft:0px;
        -webkit-border-bottom-left-radius:0px;
        border-bottom-left-radius:0px;
    }.CSSTableGenerator tr:hover td{
        background-color:#ffffff;


    }

    .CSSTableGenerator td{
        vertical-align:middle;

        background-color:#ffffff;

        border:1px solid #000000;
        border-width:0px 1px 1px 0px;
        padding:1px;
        font-size:9px;
        font-family:Arial;
        font-weight:bold;
        color:#000000;
    }.CSSTableGenerator tr:last-child td{
        border-width:0px 1px 0px 0px;
    }.CSSTableGenerator tr td:last-child{
        border-width:0px 0px 1px 0px;
    }.CSSTableGenerator tr:last-child td:last-child{
        border-width:0px 0px 0px 0px;
    }

    .printable{
        background-color: white; 
        padding: 13px;
        width: 95%;
        height: 800px;
    }

    .cabecera{
        width: 100%; 
        color: black;
        margin-bottom: 10px;
    }

    .estados1{
        width: 100%; 
        margin-top: 10px;
    }

    .tabla1{
        margin-top: 10px;
    }
</style>
<section role="main" id="main">
    <div class="columns">
        <div class="twelve-columns">
            <?php foreach ($subdealers as $subo):?>
            <div class="printable" id="area_imprime">
                <table class="cabecera">
                    <tr>
                        <td align="center" style="font-weight: bold; font-size: 14px;">HOJA DE RUTEO DIARIO DISTRIBUIDOR</td>
                    </tr>
                </table>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 45%;">
                            <table class="CSSTableGenerator">
                                <tr>
                                    <td style="width: 50%;">DEALER</td>
                                    <td style="width: 50%;">SILVIA SEJAS</td>
                                </tr>
                                <tr>
                                    <td>FECHA:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>DISTRIBUIDOR</td>
                                    <td><?= $persona['User']['nombre_persona']?></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 15%;">

                        </td>
                        <td style="width: 40%;">
                            <table class="CSSTableGenerator">
                                <tr>
                                    <td style="width: 30%;">CODIGO MERCADO</td>
                                    <td style="width: 35%;"></td>
                                    <td style="width: 35%;"></td>
                                </tr>
                                <tr>
                                    <td>MERCADO</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="estados1">
                    <tr>
                        <td style="width: 30%;">
                            <table class="CSSTableGenerator">
                                <tr>
                                    <td style="width: 50%;" align="center">ESTADO DEL PUNTO</td>
                                    <td style="width: 10%;" align="center">1</td>
                                    <td style="width: 40%;" align="center">Activo</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="center">2</td>
                                    <td align="center">FUERA DE SERVICIO</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="center">3</td>
                                    <td align="center">CERRADO</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 5%;">

                        </td>
                        <td style="width: 20%;">
                            <table class="CSSTableGenerator">
                                <tr>
                                    <td rowspan="2" align="center">
                                        CAPACITACION
                                    </td>
                                    <td align="center">1</td>
                                    <td align="center">SI</td>
                                </tr>
                                <tr>
                                    <td align="center">2</td>
                                    <td align="center">NO</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 45%;">

                        </td>
                    </tr>
                </table>
                <table class="CSSTableGenerator tabla1">
                    <tr>
                        <td>Nro</td>
                        <td>CODIGO</td>
                        <td style="width: 24%;">NOMBRE</td>
                        <td style="width: 4%;">ESTADO PDV</td>
                        <td>CAP</td>
                        <td>CHIPS</td>
                        <td>4G</td>
                        <td>TJ 10</td>
                        <td>TJ 30</td>
                        <td>TJ 50</td>
                        <td>TJ 90</td>
                        <td>LD 10</td>
                        <td>LD 15</td>
                        <td>LD 25</td>
                        <td>LD 50</td>
                        <td style="width: 3%;">LD 100</td>
                        <td style="width: 3%;">TJ P 40</td>
                        <td style="width: 3%;">TJ P 100</td>
                        <td>RECARGA</td>
                        <td>#RECARGA</td>
                        <td>LINEA ABONABLE</td>
                        <td>FIRMA SUS DEALER</td>
                    </tr>
                    <?php $i = 0; ?>
                    <?php foreach ($subo['subdealers'] as $sub): ?>
                      <?php $i++; ?>
                      <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $sub['Cliente']['cod_dealer']; ?></td>
                          <td><?php echo substr($sub['Cliente']['nombre'], 0, 40); ?></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</section>	

<?php echo $this->element('sidebar/administrador'); ?>