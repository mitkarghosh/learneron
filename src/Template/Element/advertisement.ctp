<?php
use Cake\Routing\Router;
if(count($advertise) > 0){
	if($advertise->page_name=='homePage'){
?>
	<div class="ad-section"><a href="<?php echo $advertise->link;?>" target="_blank"><img src="<?php echo Router::url('/');?>uploads/advertisement/thumb/<?php echo $advertise->image;?>" alt=""></a></div>
<?php }else{ ?>
	<div class="col-sm-12">
		<div class="intro clearfix" align="center">
			<div><a href="<?php echo $advertise->link;?>" target="_blank"><img src="<?php echo Router::url('/');?>uploads/advertisement/thumb/<?php echo $advertise->image;?>" alt=""></a></div>
		</div>
	</div>
<?php
	}
}
?>