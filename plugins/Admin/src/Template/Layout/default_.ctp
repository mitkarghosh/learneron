<!doctype html>
<html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> <?php echo WEBSITE_NAME; ?> </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <?php echo $this->Html->css('/admin/css/vendor.css') ?>
        <!-- Theme initialization -->
        <script>
            var themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) : {};
            var themeName = themeSettings.themeName || '';
            if (themeName) {
                document.write('<link rel="stylesheet" href="<?php echo $this->request->webroot; ?>admin/css/app-' + themeName + '.css">');
            } else {
                document.write('<?php echo $this->Html->css('/admin/css/app.css') ?>');
            }
        </script>
    </head>

    <body>
        <div class="main-wrapper">
            <div class="app" id="app">
                <?php echo $this->element('header'); ?>

                <?php echo $this->element('sidebar'); ?>

                <?php echo $this->fetch('content'); ?>

                <?php echo $this->element('footer'); ?>
            </div>
        </div>
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
        <?php echo $this->Html->script('/admin/js/vendor.js') ?>
        <?php echo $this->Html->script('/admin/js/app.js') ?>
    </body>

</html>