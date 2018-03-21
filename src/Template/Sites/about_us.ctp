<?php use Cake\Routing\Router; ?>
<div class="genpage-user-system">
    <div class="container">
		<div class="title">
			<h1><?php echo $cms_data->title;?></h1>
		</div>
		<div class="genpage-wrapper about-wrapper">
			<div class="row">          
				<div class="col-md-12 col-sm-12">
					<?php echo $cms_data->description;?>					
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function show_details(){
	var data = document.getElementById('show');
    if (data != '') {
		setTimeout(function(){
			$('#show').removeClass('hidedetails').addClass('shwdetail');
		},200);
		$('#show').show(500);		
		$('#show_more').hide();
    }
}
</script>