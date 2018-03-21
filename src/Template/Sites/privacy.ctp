<?php use Cake\Routing\Router; ?>
<div class="genpage-user-system">
    <div class="container">
		<div class="title">
			<h1><?php echo $cms_data->title;?></h1>
		</div>
		<div class="genpage-wrapper about-wrapper">
			<div class="row">          
				<div class="col-md-12 col-sm-12">
					<h5>Personal data protection</h5>
				<?php if(empty($Auth)){ ?>
					<p>I hereby acknowledge that I have read and agree to the Portal Terms and Conditions.</p>
				<?php } ?>	
					<?php echo $cms_data->description;?>
				</div>
			</div>
		</div>
    </div>
</div>
<script>
function show_details(id){
	var data = document.getElementById('show_'+id);
    if (data != '') {
		setTimeout(function(){
			$('.col-sm-12').each(function() {
				$('.displayclass').hide();
				$('.displayclass').removeClass('shwdetail').addClass('hidedetails');
			});
			$('#show_'+id).removeClass('hidedetails').addClass('shwdetail');
			$('#show_'+id).show(500);
		},200);
		$('#show_'+id).show(500);
    }
}
</script>