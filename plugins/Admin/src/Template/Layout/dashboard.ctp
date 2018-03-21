<?php use Cake\Routing\Router; ?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> <?php echo WEBSITE_NAME; ?> </title>
        <?php echo $this->Html->meta('icon') ?>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <?php echo $this->Html->css('/admin/css/vendor.css'); ?>
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
        <?php echo $this->Html->script('/admin/js/jquery.min.js') ?>        		
		<!-- Bootstrap Core CSS -->
		<?php echo $this->Html->css('/admin/dashboard/bootstrap.min.css');?>
		<!-- Timeline CSS -->
		<?php echo $this->Html->css('/admin/dashboard/timeline.css');?>
		<?php echo $this->Html->css('/admin/dashboard/style_sheet.css');?>
		
		<style>
		.app .content{padding: 120px 20px 100px;}
		.panel a {color: #337ab7;text-decoration: none;}
		.panel-green a{color: #5cb85c;text-decoration: none;}
		.panel-green{border-color: #5cb85c;}
		.panel-blue .panel-heading {height: 100px;}
		.panel-green .panel-heading {border-color: #5cb85c; color: #fff; background-color: #5cb85c; height: 100px;}
		.panel-heading {padding: 10px 15px; border-bottom: 1px solid transparent; border-top-left-radius: 3px; border-top-right-radius: 3px;}
		.panel-yellow {border-color: #f0ad4e;}
		.panel-yellow a{color: #f0ad4e; text-decoration: none;}
		.panel-yellow .panel-heading {border-color: #f0ad4e; color: #fff; background-color: #f0ad4e; height: 100px;}
		.panel-deepgreen {border-color: #00a65a;}
		.panel-deepgreen a{color: #00a65a; text-decoration: none;}
		.panel-deepgreen .panel-heading {border-color: #00a65a; color: #fff; background-color: #00a65a; height: 100px;}
		.panel-sky {border-color: #00c0ef;}
		.panel-sky a{color: #00c0ef; text-decoration: none;}
		.panel-sky .panel-heading {border-color: #00c0ef; color: #fff; background-color: #00c0ef; height: 100px;}
		.huge {font-size: 30px;}
		.panel-red {border-color: #d9534f;}
		.panel-red a{color: #d9534f; text-decoration: none;}
		.panel-red .panel-heading {border-color: #d9534f; color: #fff; background-color: #d9534f; height: 100px;}
		</style>
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
        <!-- Morris Charts JavaScript -->
		<?php echo $this->Html->script('/admin/dashboard/morrisjs/morris.min.js') ?>
    </body>
</html>