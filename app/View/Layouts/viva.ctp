<!DOCTYPE html>

<!--[if IEMobile 7]><html class="no-js iem7 oldie"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js ie7 oldie" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js ie8 oldie" lang="en"><![endif]-->
<!--[if (IE 9)&!(IEMobile)]><html class="no-js ie9" lang="en"><![endif]-->
<!--[if (gt IE 9)|(gt IEMobile 7)]><!--><html class="no-js" lang="en"><!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>SISTEMA-SASEZ</title>
        <meta name="description" content="Viva">
        <meta name="author" content="LabWare">

        <!-- http://davidbcalhoun.com/2010/viewport-metatag -->
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- For all browsers -->
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/reset.css?v=1">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/style.css?v=1">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/colors.css?v=1">
        <link rel="stylesheet" media="print" href="<?php echo $this->webroot; ?>css/print.css?v=1">

        <!-- For progressively larger displays -->
        <link rel="stylesheet" media="only all and (min-width: 480px)" href="<?php echo $this->webroot; ?>css/480.css?v=1">
        <link rel="stylesheet" media="only all and (min-width: 768px)" href="<?php echo $this->webroot; ?>css/768.css?v=1">
        <link rel="stylesheet" media="only all and (min-width: 992px)" href="<?php echo $this->webroot; ?>css/992.css?v=1">
        <link rel="stylesheet" media="only all and (min-width: 1200px)" href="<?php echo $this->webroot; ?>css/1200.css?v=1">
        <!-- For Retina displays -->
        <link rel="stylesheet" media="only all and (-webkit-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5)" href="<?php echo $this->webroot; ?>css/2x.css?v=1">

        <!-- Webfonts -->
        <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>-->

        <!-- Additional styles -->
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/styles/form.css?v=1">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/styles/switches.css?v=1">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/styles/table.css?v=1">

        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>js/libs/DataTables/jquery.dataTables.css?v=1">

        <!-- JavaScript at bottom except for Modernizr -->
        <script src="<?php echo $this->webroot; ?>js/libs/modernizr.custom.js"></script>

        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/styles/modal.css?v=1">
        <!-- For Modern Browsers -->
        <link rel="shortcut icon" href="<?php echo $this->webroot; ?>img/favicons/favicon.png">
        <!-- For everything else -->
        <link rel="shortcut icon" href="<?php echo $this->webroot; ?>img/favicons/favicon.ico">
        <!-- For retina screens -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->webroot; ?>img/favicons/apple-touch-icon-retina.png">
        <!-- For iPad 1-->
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->webroot; ?>img/favicons/apple-touch-icon-ipad.png">
        <!-- For iPhone 3G, iPod Touch and Android -->
        <link rel="apple-touch-icon-precomposed" href="<?php echo $this->webroot; ?>img/favicons/apple-touch-icon.png">

        <!-- iOS web-app metas -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- Startup image for web apps -->
        <link rel="apple-touch-startup-image" href="<?php echo $this->webroot; ?>img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        <link rel="apple-touch-startup-image" href="<?php echo $this->webroot; ?>img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="<?php echo $this->webroot; ?>img/splash/iphone.png" media="screen and (max-device-width: 320px)">

        <!-- Microsoft clear type rendering -->
        <meta http-equiv="cleartype" content="on">
        <!-- Scripts -->
        <script src="<?php echo $this->webroot; ?>js/libs/jquery-1.10.2.min.js"></script>

        <?php
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>        

    </head>

    <body class="clearfix with-menu with-shortcuts">
        <script>var urljsontabla = '';
          var datos_tabla2 = null;</script>
        <!-- Prompt IE 6 users to install Chrome Frame -->
        <!--[if lt IE 7]><p class="message red-gradient simpler">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

        <!-- Title bar -->
        <header class="no-imprime" role="banner" id="title-bar">
            <h2>SISTEMA DE INVENTARIOS</h2>
        </header>

        <!-- Button to open/hide menu -->
        <a class="no-imprime" href="#" id="open-menu"><span>Menu</span></a>

        <!-- Button to open/hide shortcuts -->
        <a class="no-imprime" href="#" id="open-shortcuts"><span class="icon-thumbs"></span></a>

        <!-- Main content -->


        <?php echo $this->fetch('content'); ?>

        <!-- End main content -->       

        <!-- Side tabs shortcuts -->
        <?php if ($this->Session->read('Auth.User.group_id') == 2): ?>
          <?php echo $this->element('menu/admindistribuidor'); ?>
        <?php elseif ($this->Session->read('Auth.User.group_id') == 1): ?>          
          <?php echo $this->element('menu/admin'); ?>             
        <?php elseif ($this->Session->read('Auth.User.group_id') == 3): ?>          
          <?php echo $this->element('menu/adminalmacen'); ?>    
        <?php elseif ($this->Session->read('Auth.User.group_id') == 4): ?>          
          <?php echo $this->element('menu/adminrecargas'); ?>  
        <?php endif; ?>

        <!-- JavaScript at the bottom for fast page loading -->

        <!-- Scripts -->
        <script src="<?php echo $this->webroot; ?>js/setup.js"></script>

        <!-- Template functions -->
        <script src="<?php echo $this->webroot; ?>js/developr.input.js"></script>
        <script src="<?php echo $this->webroot; ?>js/developr.navigable.js"></script>
        <script src="<?php echo $this->webroot; ?>js/developr.notify.js"></script>
        <script src="<?php echo $this->webroot; ?>js/developr.scroll.js"></script>
        <script src="<?php echo $this->webroot; ?>js/developr.tooltip.js"></script>
        <script src="<?php echo $this->webroot; ?>js/developr.table.js"></script>
        <script src="<?php echo $this->webroot; ?>js/developr.modal.js"></script>

        <?php echo $this->element('jsvalidador') ?>
        <!-- Plugins -->
        <script src="<?php echo $this->webroot; ?>js/libs/jquery.tablesorter.min.js"></script>
        <script src="<?php echo $this->webroot; ?>js/libs/DataTables/jquery.dataTables.min.js"></script>
        <?php echo $this->fetch('js_add'); ?>
        <script>
          // Call template init (optional, but faster if called manually)
          $.template.init();

          // Table sort - DataTables
          var table = $('#sorting-advanced');
          table.dataTable({
              "oLanguage": {
                  "sUrl": "<?php echo $this->webroot; ?>js/libs/DataTables/Spanish.json"
              },
              'sPaginationType': 'full_numbers',
              'sDom': '<"dataTables_header"lfr>t<"dataTables_footer"ip>',
              "order": [],
              'fnInitComplete': function (oSettings)
              {
                  // Style length select
                  table.closest('.dataTables_wrapper').find('.dataTables_length select').addClass('select blue-gradient glossy').styleSelect();
                  tableStyled = true;
              }
          });

          var table2 = $('#tabla-json');
          if (datos_tabla2 == null) {
              datos_tabla2 = {
                  "oLanguage": {
                      "sUrl": "<?php echo $this->webroot; ?>js/libs/DataTables/Spanish.json"
                  },
                  'sPaginationType': 'full_numbers',
                  'sDom': '<"dataTables_header"lfr>t<"dataTables_footer"ip>',
                  'bProcessing': true,
                  'sAjaxSource': urljsontabla,
                  'sServerMethod': 'POST',
                  "order": [],
                  'fnInitComplete': function (oSettings)
                  {
                      // Style length select
                      table2.closest('.dataTables_wrapper').find('.dataTables_length select').addClass('select blue-gradient glossy').styleSelect();
                      tableStyled = true;
                  }
              };
          }
          table2.dataTable(datos_tabla2);

          function cargarmodal(url, titulo) {
              $.modal({
                  content: '<div id="idmodal"></div>',
                  title: titulo,
                  width: 600,
                  height: 400,
                  actions: {
                      'Cerrar': {
                          color: 'red',
                          click: function (win) {
                              win.closeModal();
                          }
                      }
                  },
                  buttonsLowPadding: true
              });
              $('#idmodal').load(url);
          }
        </script>
        <?php echo $this->Session->flash(); ?>

        <div class="no-imprime" style="text-align: center; color:gray;">
            <p class="f-left">&copy; 2015 <strong class="green">SEJAS SRL.</strong>, Todos Los Derechos Reservados &reg;</p>
            <p class="f-right">Dise&ntilde;ado y Desarrollado por la Consultora <a href="http://www.virtualware.com.bo/">VirtualWare</a></p>
        </div> 
    </body>
</html>