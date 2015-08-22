<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//debug($ruta);
?>
<div data-role="content">
    <div data-role="collapsible-set" data-theme="b" data-content-theme="">
        <div data-role="collapsible" data-collapsed="false">
            <h3>
                Datos de la ruta
            </h3>
            <div>
                <b>
                    Codigo 149:&nbsp;
                </b>
                <?php echo $ruta['Cliente']['num_registro']; ?>
                <b>
                    <br />
                </b>
            </div>
            <div>
                <b>
                    Cliente:&nbsp;
                </b>
                <?php echo $ruta['Cliente']['nombre']; ?>
                <b>
                    <br />
                </b>
            </div>
            <div>
                <b>
                    Direccion:&nbsp;
                </b>
                <?php echo $ruta['Cliente']['direccion']; ?>
                <b>
                    <br />
                </b>
            </div>
            <div>
                <b>
                    Estado:&nbsp;
                </b>
                Pendiente
                <b>
                    <br />
                </b>
            </div>
        </div>
    </div>
    <a data-role="button" data-transition="fade" href="#page2" data-icon="check" data-iconpos="left" id="vmapa">
        Ver Mapa
    </a>
    <a href="1.html" data-rel="dialog" data-role="button" >Open dialog</a>
    <a data-role="button" href="1.html" data-rel="dialog">
        Observaciones
    </a>
    <a data-role="button" data-transition="fade" href="#page4">
        Ventas
    </a>
    <div data-role="page" id="dialog">
        <div data-role="header">
            <h1>Your Message</h1>
        </div>    
        <div data-role="content" id="text">
        </div>    
    </div>
</div>