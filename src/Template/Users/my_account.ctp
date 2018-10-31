<?php
use Cake\Routing\Router;
$session  = $this->request->session();
?>
<div class="genpage-user-system">
    <div class="container">
		<div class="title">
			<h1>User Profile</h1>
		</div>
		<div class="genpage-wrapper">
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<div class="user-profile-photo">
					<?php
					if($user_related_details['profile_pic'] != ''){
						$image = Router::url("/uploads/user_profile_pic/thumb/", true).$user_related_details['profile_pic'];
					}else{
						$image = Router::url("/images/", true).'user.png';
					}
					?>
						<figure><img src="<?php echo $image; ?>" alt="" id='img_to_show' /></figure>
					<?php
					if($user_related_details['type'] == 'N'){	//for normal users (not logged in using social media)
						echo $this->Form->create(false, array('url'=>'javascript:void(0)', 'class'=>'profile_pic_form', 'novalidate' => 'novalidate', 'id'=>'profile_pic_form', 'enctype'=>'multipart/form-data'));
					?>
						<div class="pic-change">
							<input type="file" name="uploadfile" id="change-avatar">
							<label for="change-avatar" class="btn-normal">Change Picture</label>
						</div>
					<?php
						echo $this->Form->end();
					}
					?>
						<div id="profile_msg"></div>						
					</div>
					<div id="profile_pic_loader" style="text-align:center;"></div>
				</div>
				<div class="col-md-9 col-sm-9">
					<div class="user-profile-details">              
						<div class="edit-details-wrapper">                
							<div class="about-user-row">
								<div id="msg_div">
								<?php
								if($session->read('reset_password')=='success'){
									echo $this->Flash->render();
									$session->delete('reset_password');
								}
								?>
								</div>
								<h3>Public Information</h3>
							<?php
							if($user_related_details['name'] != ''){
							?>
								<h5>Name or Nick Name</h5>
								<p><?php echo $user_related_details['name'];?></p>
							<?php
							}
							if($user_related_details['location'] != ''){
							?>
								<h5>Location</h5>
								<p><?php echo $user_related_details['location'];?></p>
							<?php
							}
							if($user_related_details['title'] != ''){
							?>
								<h5>Title</h5>
								<p><?php echo $user_related_details['title'];?></p>
							<?php
							}
							if($user_related_details['about_me'] != ''){							
							?>
								<h5>About Me</h5>
								<p><?php echo $user_related_details['about_me'];?></p>
							<?php
							}
							?>
							</div>
							<?php
							if($user_related_details['facebook_link'] != '' || $user_related_details['twitter_link'] != '' || $user_related_details['gplus_link'] != '' || $user_related_details['linkedin_link'] != ''){
							?>
							<div class="about-user-row">
								<h3>Web Preference</h3>
								<div class="row">
								<?php 
								if($user_related_details['twitter_link'] != ''){
								?>
									<div class="col-md-6">
										<h5>Twitter Link</h5>
										<a href="<?php echo $user_related_details['twitter_link'];?>" target="_blank"><?php echo $user_related_details['twitter_link'];?></a>
									</div>
								<?php 
								}
								if($user_related_details['facebook_link'] != ''){
								?>
									<div class="col-md-6">
										<h5>Facebook Link</h5>
										<a href="<?php echo $user_related_details['facebook_link'];?>" target="_blank"><?php echo $user_related_details['facebook_link'];?></a>
									</div>
								<?php
								}
								if($user_related_details['gplus_link'] != ''){
								?>
									<div class="col-md-6">
										<h5>Google Plus Link</h5>
										<a href="<?php echo $user_related_details['gplus_link'];?>" target="_blank"><?php echo $user_related_details['gplus_link'];?></a>
									</div>
								<?php
								}
								if($user_related_details['linkedin_link'] != ''){
								?>
									<div class="col-md-6">
										<h5>Linkedin Link</h5>
										<a href="<?php echo $user_related_details['linkedin_link'];?>" target="_blank"><?php echo $user_related_details['linkedin_link'];?></a>
									</div>
								<?php
								}
								?>
								</div>
							</div>
							<?php
							}
							if(!empty($user_related_details['careereducations'])){
							?>
							<div class="about-user-row">
								<h3>Career & Education History</h3>
							<?php
								$e=0; $c=0;
								foreach($user_related_details['careereducations'] as $ca){
									if($ca['history_type']=='E'){
							?>
										<div class="row">
							<?php 		if($e==0){ ?>
											<div class="col-md-12">
												<p>Education</p>
											</div>
							<?php		} ?>
											<div class="col-md-6">
							<?php 		if($e==0){ ?>
												<h5>Educational Details</h5>
							<?php		} ?>
												<p><?php echo @$ca['edu_degree'];?> At <?php echo @$ca['edu_organization'];?></p>
											</div>
											<div class="col-md-6">
							<?php 		if($e==0){ ?>
												<h5>Time Period</h5>
							<?php		} ?>
												<p>From <?php echo date('jS F Y',strtotime($ca['edu_from']));?> To <?php echo date('jS F Y',strtotime($ca['edu_to']));?></p>
											</div>									
										</div>
							<?php
									$e++;
									}
									else if($ca['history_type']=='C'){
							?>
										<div class="row">
							<?php 		if($c==0){ ?>
											<div class="col-md-12">
												<p>Work</p>
											</div>
							<?php		} ?>
											<div class="col-md-6">
							<?php 		if($c==0){ ?>
												<h5>Company Details</h5>
							<?php		} ?>
												<p><?php echo @$ca['career_position'];?> At <?php echo @$ca['career_company'];?></p>
											</div>
											<div class="col-md-6">
							<?php 		if($c==0){ ?>
												<h5>Time Period</h5>
							<?php		} ?>
												<p>From <?php echo date('jS F Y',strtotime($ca['career_from']));?> To <?php echo date('jS F Y',strtotime($ca['career_to']));?></p>
											</div>									
										</div>
							<?php
									$c++;
									}
								}
							?>
							</div>
							<?php
							}
							?>
							
							<h3>Private Information</h3>
								<div class="row form-row">
								<?php
								if($user_related_details['full_name'] != ''){
								?>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Full Name</label><br />
											<?php echo $user_related_details['full_name'];?>
										</div>
									</div>
								<?php
								}
								if($user_related_details['email'] != ''){
								?>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Email</label><br />
											<?php echo $user_related_details['email'];?>
										</div>
									</div>
								<?php
								}
								?>
								</div>
								<?php
								if($user_related_details['birthday']!='' && $user_related_details['birthday']!=NULL){
								?>
								<div class="row form-row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Birthday</label><br />
											<?php echo $dob = date('m/d/Y', strtotime($user_related_details['birthday']));?>
										</div>
									</div>								
								</div>
								<?php
								}
								?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Setting Popup -->
<div class="modal fade bd-example-modal-lg" id="redirect_login_setting_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">See Settings Page</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo $this->Form->create(false, array('url'=>'javascript:void(0)', 'class'=>'', 'novalidate' =>'novalidate','id'=>'setting_form'));?>
					<?php echo $this->Form->input('user_id', ['type'=>'hidden','id'=>'user_id','label'=>false]);?>
					<div class="check-box-set">
						<input type="checkbox" id="is_setting" name="is_setting" value="1" checked>
						<!--<label for="is_setting">See Settings Now</label>-->
					</div>
					<p id="setting_check_error"></p>
					<div class="text-right">
						<button type="button" class="btn btn-alt" data-dismiss="modal">No</button>
						<a href="<?php echo Router::url("/account-setting/",true); ?>" class="btn btn-normal">Yes</a>
					</div>
					<div class="setting_loader" style="text-align:center;"></div>
				<?php echo $this->Form->end(); ?>
			</div>			
		</div>
	</div>
</div>
<!-- Setting Popup -->

<script>
$(document).ready(function(){
	<?php
	if($user_related_details->see_setting_page == 1){
	?>
		$.ajax({
            url : '<?php echo Router::url("/users/see_setting_now_update/",true); ?>',
            type : 'POST',
            success : function( response ) {
                $('#redirect_login_setting_data').modal('show');
            }
        });		
	<?php
	}
	?>
	setTimeout(function(){
		$('#msg_div').html('');
		$('#profile_msg').html('');
	},10000);
});

//For update profile picture
$('#change-avatar').change(function(){
    var form = $('#profile_pic_form')[0]; // You need to use standart javascript object here
    //console.log($('input[type=file]')[0].files[0]);
	var formData = new FormData();
	formData.append('image', $('input[type=file]')[0].files[0]);
	$("#profile_pic_loader").html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
	$.ajax({
	    url : "<?php echo Router::url("/users/upload-profile-picture/",true); ?>",
	    type: "POST",
	    data : formData,
	    processData: false,
	    contentType: false,
	    success:function(response, textStatus, jqXHR){
	        var response = JSON.parse(response);
			$("#profile_pic_loader").html('');
	        if(response.data=='failed'){
	        	var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Error uploading picture, please try again later.</div>";
	              $('#profile_msg').html(msg);
	        }else{
	        	var image = "<?php echo Router::url("/uploads/user_profile_pic/thumb/",true); ?>"+response.data;
	        	$('#img_to_show').attr('src', image);
	        	$('#user_image').attr('src', image);
	        	var msg = "<div class='message success' onclick='this.classList.add('hidden')'>Profile picture updated successfully..</div>";
	              $('#profile_msg').html(msg);
	        }
	    },
	    error: function(jqXHR, textStatus, errorThrown){
	        $("#profile_pic_loader").html('');
	        var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Error uploading picture, please try again later.</div>";
			$('#profile_msg').html(msg);     
	    }
	});
});
</script>