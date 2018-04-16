<?php use Cake\Routing\Router; ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=1">
<meta name="Description" content="<?php if(isset($meta_description) && $meta_description !=''){ echo $meta_description; }else{ echo 'LearnerOn'; } ?>" />
<meta name="Keywords" content="<?php if(isset($meta_keywords) && $meta_keywords !=''){ echo $meta_keywords; }else{ echo 'LearnerOn'; } ?>" />
<title><?php if(isset($title)){ echo $title.' | '; } ?>LearnerOn</title>
<!-- Global site tag (gtag.js) - Google Analytics -->

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-102577389-3"></script>

<script>

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());

 

  gtag('config', 'UA-102577389-3');

</script>
<?php echo $this->Html->meta('icon') ?>
<!--boot-strap -->
<?php echo $this->Html->css('bootstrap.min'); ?>
<?php echo $this->Html->css('jquery.mCustomScrollbar.min'); ?>
<?php echo $this->Html->css('jquery.bxslider.min'); ?>
<?php echo $this->Html->css('bootstrap-datepicker.min'); ?>
<?php echo $this->Html->css('style') ?>

<!-- Responsive-->
<?php echo $this->Html->css('responsive'); ?>

<!-- custom -->
<?php echo $this->Html->css('development'); ?>

<!-- js -->
<?php echo $this->Html->script('jquery'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script> 
<?php echo $this->Html->script('bootstrap.min'); ?>
<?php echo $this->Html->script('jquery.mCustomScrollbar.min'); ?>
<?php
if(isset($this->request->params) && ($this->request->params['controller']=='Sites' || $this->request->params['controller']=='Questions')){
	echo $this->Html->script('jquery.bxslider.min');
?>
	<script>
	$(document).ready(function(){
		$('.category .side-bar-block-box').mCustomScrollbar({theme:"dark-thick"});
		/*$('.banner-slider').bxSlider({
			auto:false
		});*/
	});
	$(window).load(function(){
		$('.banner-slider').bxSlider({
			auto:false,
			infiniteLoop: false,
			onSliderLoad: function () {
				$(".banner-wrapper").css("visibility", "visible");
				$(".banner-sec #divLoading").removeClass('show');
			}
		});
	});
	$(document).on('click', '.bx-next', function () {
		var frame = document.getElementById("fitvid0");
		frame.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
	});
	$(document).on('click', '.bx-prev', function () {
		var frame = document.getElementById("fitvid0");
		frame.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
	});
	$(document).on('click', '.bx-pager', function () {
		var frame = document.getElementById("fitvid0");
		frame.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
	});
	</script>
<?php
}else if(isset($this->request->params) && ($this->request->params['controller']=='News')){
	echo $this->Html->script('masonry.pkgd.min');
	echo $this->Html->script('editor');
?>
	<script>
	 $(document).ready(function(){
		$('.news-listing').masonry({
			// options
			itemSelector: '.news-item',
			columnWidth: 272,
			gutter:22,
			percentPosition: true
		});		 
		$('.category .side-bar-block-box').mCustomScrollbar({theme:"dark-thick"});
	 });
	</script>
<?php
}
?>
<?php echo $this->Html->script('custom'); ?>
<?php echo $this->Html->script('validate.min'); ?>
<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5aad468fd2394a00142107af&product=inline-share-buttons"></script>
</head>
<body>
<div class="wrapper">
<?php echo $this->element('header'); ?>
<?php echo $this->fetch('content'); ?>
<?php echo $this->element('footer'); ?>
<script>
$('[data-toggle="tooltip"]').tooltip({
	placement : 'top'
});
$('[data-toggle="tooltip_personaldata"]').tooltip({
	placement : 'top'
});
</script>
</div>
</body>
</html>