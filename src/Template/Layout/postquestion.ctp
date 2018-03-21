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
<?php echo $this->Html->meta('icon') ?>
<!--boot-strap -->
<?php echo $this->Html->css('bootstrap.min'); ?>
<?php echo $this->Html->css('summernote') ?>
<?php echo $this->Html->css('style') ?>

<!-- Responsive-->
<?php echo $this->Html->css('responsive'); ?>

<!-- custom -->
<?php echo $this->Html->css('development'); ?>

<!-- js -->
<?php echo $this->Html->script('jquery'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script> 
<?php echo $this->Html->script('bootstrap.min'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script> 
<?php echo $this->Html->script('custom'); ?>
<?php echo $this->Html->script('summernote.min'); ?>
<script>
$(document).ready(function(){
   $('#learning-goal').summernote({	
		popover: {
			image: [],
			link: [],
			air: []
		},
		height:250,
		placeholder:'What subject of learning and target level you want to achieve'
	});
	$('#budget_constraints').summernote({	
		popover: {
			image: [],
			link: [],
			air: []
		},
		height:250,
		placeholder:'Please enter any monetary limits, timing constraints (eg, "available only on evenings"), language preferences, ability or not to travel for education and similar matters or preferences'
	});
	$('#preferred_learning_mode').summernote({	
		popover: {
			image: [],
			link: [],
			air: []
		},
		height:250,
		placeholder:'Eg, learning by reading, learning by listening, learning by practicing, online interactive delivery, onsite in-person delivery in classroom set-up, one-on-one delivery or similar preference'
	});
	$('#recomandation').summernote({	
		popover: {
			image: [],
			link: [],
			air: []
		},
		height:250,
		placeholder:'What particular learning path, i.e. a succession of learning steps, courses, bootcamps, coachings or any other learning means would you recommend given the starting level, budget and other constraints and preferences?'
	});
	$('#learning-experience').summernote({	
		popover: {
			image: [],
			link: [],
			air: []
		},
		height:250,
		placeholder:'How would you describe your experience, or review of the courses and learning steps per the recommended Learning Path'
	});
	$('#utility').summernote({	
		popover: {
			image: [],
			link: [],
			air: []
		},
		height:250,
		placeholder:'Did the learning you experienced lead you to the effect you wanted – e.g., to being successful in finding a new job, in salary progression, in enjoyment or any other utility you promised to yourself'
	});
	
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');
		//tabs
		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	});	
});


$('[rel=tooltip]').tooltip()        
$('[rel=tooltip]').tooltip('disable') 
$('[rel=tooltip]').tooltip('enable')  
$('[rel=tooltip]').tooltip('destroy') 
</script>
<?php echo $this->Html->css('multiselect/fastselect.min.css'); ?>
<?php echo $this->Html->script('multiselect/fastselect.standalone.js'); ?>
<?php echo $this->Html->script('validate.min'); ?>
<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5aad468fd2394a00142107af&product=inline-share-buttons"></script>
</head>
<body>

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
</body>
</html>