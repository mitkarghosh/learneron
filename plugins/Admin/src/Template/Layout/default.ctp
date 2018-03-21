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
        <?php echo $this->Html->script('validate.min'); ?>
        <?php echo $this->Html->script('/admin/js/custom.js') ?>
		
		<?php echo $this->Html->script('/admin/sweetalert/sweetalert.js') ?>
		<?php echo $this->Html->css('/admin/sweetalert/sweetalert.css'); ?>
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

        <?php if($this->fetch('hasDatepicker')): ?>
            <?php echo $this->Html->css('/admin/css/jquery-ui.min.css'); ?>
            <?php echo $this->Html->script('/admin/js/jquery-ui.min.js') ?>
            <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
            <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
        <?php endif; ?>

        <!-- Summernote Editor -->
        <?php if($this->fetch('needEditor')): ?>
        <?php echo $this->Html->css('/admin/summernote/summernote.css'); ?>
        <?php echo $this->Html->script('/admin/summernote/summernote.min.js'); ?>
            <script type="text/javascript">
                $(function() {
                    function uploadImage(image) {
                        var data = new FormData();
                        data.append("image", image);
                        $("div#divLoading").addClass('show');
                        $.ajax({
                            url: '<?php echo Router::url("/admin/admin-detail/upload-editor-image/", true); ?>',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: data,
                            type: "post",
                            success: function(url) {
                                $('.note-icon-picture').trigger('click');
                                $('.note-image-url').val(url);
                                $('.note-image-btn').trigger("click");
                                $("div#divLoading").removeClass('show');
                            },
                            error: function(data) {
                                console.log(data);
                                $("div#divLoading").removeClass('show');
                            }
                        });
                    }
                  $('<?php echo $this->fetch('editor_id'); ?>').summernote({
                    height: 200,
                    callbacks: {
                        onImageUpload: function(image) {
                            uploadImage(image[0]);
                        }
                    },
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['insert', ['link', 'hr']],
                        ['view', ['fullscreen', 'codeview']],
                        //['help', ['help']]
                      ]
                  });
                });
              </script>
        <?php endif; ?>
        <?php if($this->fetch('needEditorContact')): ?>
        <?php echo $this->Html->css('/admin/summernote/summernote.css'); ?>
        <?php echo $this->Html->script('/admin/summernote/summernote.min.js'); ?>
            <script type="text/javascript">
                $(function() {
                  $('<?php echo $this->fetch('editor_id'); ?>').summernote({
                    height: 200,
                    callbacks: {
                        onImageUpload: function(image) {
                            uploadImage(image[0]);
                        }
                    },
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['view', ['fullscreen', 'codeview']],
                        ['help', ['help']]
                      ]
                  });
                });
              </script>
        <?php endif; ?>
        <!-- Summernote Editor End -->

        <script type="text/javascript">
	        if($('.message.success').length){
	        	setTimeout(function(){
	        		$('.message.success').trigger('click');
	        	},3000);
	        }
        </script>
    </body>

</html>