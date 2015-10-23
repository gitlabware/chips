<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema Viva</title>
	<link rel="shortcut icon" href="<?php echo $this->webroot;?>favicon.ico">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="<?php echo $this->webroot;?>css/themes/default/jquery.mobile-1.4.2.min.css">
    <!--<link rel="stylesheet" href="<?php //echo $this->webroot;?>themes/temamobile.min.css" >-->
	<link rel="stylesheet" href="<?php echo $this->webroot;?>_assets/css/jqm-demos.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="https://rawgithub.com/arschmitz/jquery-mobile-datepicker-wrapper/v0.1.1/jquery.mobile.datepicker.css" />
	<script src="<?php echo $this->webroot; ?>js/jquery.js"></script>
    
	<script src="<?php echo $this->webroot;?>_assets/js/index.js"></script>
    
	<script src="<?php echo $this->webroot;?>js/jquery.mobile-1.4.2.min.js"></script>
    <script src="https://rawgithub.com/jquery/jquery-ui/1.10.4/ui/jquery.ui.datepicker.js"></script>
    <script id="mobile-datepicker" src="https://rawgithub.com/arschmitz/jquery-mobile-datepicker-wrapper/v0.1.1/jquery.mobile.datepicker.js"></script>
    
    
</head>
<body>
<div data-role="page" class="jqm-demos ui-responsive-panel" id="panel-responsive-page1" data-title="Panel responsive page">

	
    <div data-role="header" data-position="inline">
				<h1>SISTEMA DE INVENTARIOS</h1>
                <a href="#nav-panel" data-icon="bars" data-iconpos="notext">Menu</a>
                
                 <a href="#add-form" data-icon="gear" data-iconpos="notext">Add</a>
			</div>

	<div role="main" class="ui-content jqm-content">
    
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->fetch('content'); ?>

	</div><!-- /content -->
    
	    <div data-role="panel" data-display="push" data-theme="b" id="nav-panel">

		<ul data-role="listview">
            <li data-icon="delete"><a href="#" data-rel="close">Cerrar Menu</a></li>
            <?php 
                    $idusuario = $this->Session->read("Auth.User.id");
                    $fecha = date('Y-m-d');
                    ?>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor','action' => 'pidecodigo_mobile'));?>" data-ajax = "false">Registrar</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor','action' => 'registrafecha_mobile'));?>" data-ajax = "false">Registrar por Fecha</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Reportes', 'action'=>'saldoshorizontal_mobile', $idusuario, $fecha)); ?>" data-ajax = "false">Reporte General</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Ventasdistribuidor', 'action'=>'reporte1492_mobile')); ?>" data-ajax = "false">Reporte 149</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Ventasdistribuidor', 'action'=>'reporte1492fecha_mobile')); ?>" data-ajax = "false">Reporte por Fecha</a></li>
                
		</ul>

	</div><!-- /panel -->

    <div data-role="panel" data-position="right" data-display="reveal" data-theme="a" id="add-form">

        	<h2>Usuario </h2>
            <h3><?php $usuario =  $this->Session->read('Auth.User.Persona');?><?php echo $usuario['nombre'].' '.$usuario['ap_paterno'].' '.$usuario['ap_materno'];?></h3>
            <ul data-role="listview">
            
                <li><a href="<?php echo $this->Html->url(array('action'=>'cambiopass_mobile', $id)); ?>" data-ajax = "false">Cambiar Password</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Ventasdistribuidor', 'action'=>'salir'))?>" data-ajax = "false">Cerrar Sesion</a></li>
                <li data-icon="delete"><a href="#" data-rel="close">Volver</a></li>
                
            </ul>

	</div><!-- /panel -->
    
	<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
		<p>jQuery Mobile Demos version <span class="jqm-version"></span></p>
		<p>Copyright 2014 The jQuery Foundation</p>
	</div><!-- /footer -->
	<!-- TODO: This should become an external panel so we can add input to markup (unique ID) -->
    


</div><!-- /page -->

</body>
</html>
