<?php use Cake\Routing\Router; ?>
<div class="genpage-user-system">
	<?php echo $this->element('advertisement'); ?>
    <div class="container">      
		<section class="top-question-section">
			<div class="container">
				<div class="row">
					<div class="col-md-9 col-sm-8">              
						<div class="clearfix">
							<div class="title pull-left inline-form-control">
								<h1>Users</h1>
							</div>
							<div class="user-search pull-right">
								<?php echo $this->Form->create('Users',['novalidate'=>'novalidate', 'type'=>'GET', 'enctype'=>'multipart/form-data']); ?>
									<label for="">Search User</label>
									<input type="text" name="name" value="<?php if($this->request->query('name')!== NULL): echo $this->request->query('name'); endif; ?>" placeholder="Nick Name" autocomplete="off" />
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
						<div class="users-left">
						<?php
						if(!empty($all_users)){
						?>
							<div class="row" id="users_listing">
						<?php
							if(!empty($alphabets_only)){
						?>
								<div class="col-md-12">								
									<div class="search-by">
										<h3>Browse by alphabetically</h3>
										<ul>
						<?php
										foreach($alphabets_only as $key_ao => $val_ao){
						?>
											<li><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'/')).'?search='.strtolower($key_ao);?>" <?php if(strtoupper($key_ao)==$element)echo 'style="color:#caa961"';?>><?php echo strtolower($key_ao);?></a></li>
						<?php
										}
						?>
											<li><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'/'));?>">All</a></li>
										</ul>           	   	
									</div>
								</div>
							<?php
							}
							?>
               	
								<?php
								foreach($all_users as $user){
								?>
									<div class="col-md-4 col-sm-12">								
										<div class="user-block">
											<figure class="user-pic">
												<!--<a href="#">-->
												<?php
												if($user->profile_pic != ''):
												?>
												<img src="<?php echo Router::url('/uploads/user_profile_pic/thumb/').$user->profile_pic;?>" alt="<?php echo $user->name;?>" />
												<?php
												else:
												?>
												<img src="<?php echo Router::url('/images/user_small.png');?>" alt="<?php echo $user->name;?>" />
												<?php
												endif;
												?>
												<!--</a>-->
											</figure>
											<div class="user-detials">
												<h5><a href="javascript:void(0);" onclick="return get_user_public_details('<?php echo $user->id;?>');"><?php echo $user->name;?></a></h5>
												<span class="user-address"><?php echo $user->location;?>&nbsp;</span>
												<div class="user-activities">
													<a href="javascript:void(0);" title="questions asked"><i class="fa fa-question-circle"></i><?php if(!empty($user->questions)): echo count($user->questions);else: echo 0; endif;?></a>
													<a href="javascript:void(0);" title="answers provided"><i class="fa fa-reply"></i><?php if(!empty($user->question_answer)): echo count($user->question_answer);else: echo 0; endif;?></a>
												</div>
												<span id="user_loader_<?php echo $user->id;?>"></span>
											</div>
										</div>
									</div>
								<?php
								}
								?>
							</div>
						<?php
						}else{
							echo '<div class="row"><p class="no_results_found">No results found</p></div>';
						}
						?>
						<?php
						if(!empty($all_users)){
						?>
							<div class="loader">
								<?php echo $this->Paginator->next('Load more'); ?>
							</div>	
						<?php
						}
						?>
						</div>
					</div>
					<div class="col-md-3 col-sm-4 question-right ">
						<?php echo $this->element('right_panel_2'); ?>
					</div>
				</div>
			</div>
		</section>
    </div>
</div>

<!-- User details Modal -->
<div class="modal fade bd-example-modal-lg" id="user_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body public_data" style="margin-top:0; padding:0;"></div>
		</div>
	</div>
</div>
<!-- User details Modal -->

<form id="search_form1">
  <input type="hidden" name="main_cat" value="" id="main_cat">
</form>
<script>
jQuery(function(){
	$(document).on('click', 'a[rel="next"]', function() {
		$('.next').remove();
		$('.loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var target = $(this).attr('href').replace("all-users","search");
		var data = $('#search_form1').serialize();
		if(!target)
			return false;
		$.post(target, data, function(data) {
			$('.loader').remove();
			var e1 = jQuery(data);
			$('.next').remove();
			$('#users_listing').append( e1 );
		}, 'html');
		return false;
	});
});

//getting answer comment section start here
function get_user_public_details(user_id){
	$('#user_loader_'+user_id).html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
	$.ajax({
		url:"<?php echo Router::url("/users/get-user-public-details/",true); ?>",
		type: 'POST',
		data: {user_id : user_id},
		success: function(data){
			$('#user_loader_'+user_id).html('');
			$('.public_data').html(data);
			$('#user_details').modal('show');
		}
	});
}
//getting answer comment section end here
</script>