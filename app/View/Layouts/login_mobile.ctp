<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema Viva</title>
	<link rel="shortcut icon" href="<?php echo $this->webroot;?>favicon.ico">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="<?php echo $this->webroot;?>css/themes/default/jquery.mobile-1.4.2.min.css">
    <!--<link rel="stylesheet" href="<?php //echo $this->webroot;?>themes/ffffff.min.css" />-->
	<link rel="stylesheet" href="<?php echo $this->webroot;?>_assets/css/jqm-demos.css">
	<script src="<?php echo $this->webroot; ?>js/jquery.js"></script>
    
	<script src="<?php echo $this->webroot;?>_assets/js/index.js"></script>
	<script src="<?php echo $this->webroot;?>js/jquery.mobile-1.4.2.min.js"></script>
    <script type="text/javascript">
/*$(document).bind("mobileinit", function()
{
  $.extend(  $.mobile , {
      ajaxFormsEnabled: false,
      //ajaxEnabled: false
  });
});*/
</script>
    
</head>
<body>
<div data-role="page" class="jqm-demos ui-responsive-panel" id="panel-responsive-page1" data-title="Sistema de Inventarios">

	
    <div data-role="header" data-position="inline">
				<h1>INGRSO AL SISTEMA</h1>
                
			</div>

	<div role="main" class="ui-content jqm-content">
    
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->fetch('content'); ?>

	</div><!-- /content -->
   
    
    


</div><!-- /page -->

</body>
</html>
