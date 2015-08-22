<!DOCTYPE html>

<!--[if IEMobile 7]><html class="no-js iem7 oldie"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js ie7 oldie" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js ie8 oldie" lang="en"><![endif]-->
<!--[if (IE 9)&!(IEMobile)]><html class="no-js ie9" lang="en"><![endif]-->
<!--[if (gt IE 9)|(gt IEMobile 7)]><!--><html class="no-js" lang="en"><!--<![endif]-->

    <head>
       
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
        <link rel="stylesheet" media="only all and (-webkit-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5)" href="css/2x.css?v=1">

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
        <script src="<?php echo $this->webroot; ?>js/libs/jquery-1.8.2.min.js"></script>
        <script src="<?php echo $this->webroot; ?>js/setup.js"></script>

        <?php
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>        

    </head>

    <body class="clearfix with-menu with-shortcuts">

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>

        <!-- Scripts -->
        <script src="<?php echo $this->webroot; ?>js/libs/jquery-1.8.2.min.js"></script>
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

        <script>
            // Call template init (optional, but faster if called manually)
            $.template.init();

            // Table sort - DataTables
            var table = $('#sorting-advanced');
            table.dataTable({
                
                'sPaginationType': 'full_numbers',
                'sDom': '<"dataTables_header"lfr>t<"dataTables_footer"ip>',
                'fnInitComplete': function( oSettings )
                {
                    // Style length select
                    table.closest('.dataTables_wrapper').find('.dataTables_length select').addClass('select blue-gradient glossy').styleSelect();
                    tableStyled = true;
                }
            });
    
        </script>

    </body>
</html>