<?php
use Cake\Routing\Router;
$session  = $this->request->session();
echo $this->Html->css('/admin/css/jquery-ui.min.css');
echo $this->Html->script('/admin/js/jquery-ui.min.js');
?>
<style>.error{color:#ff0000;}</style>
<div class="genpage-user-system">
    <div class="container">
		<div class="title">
			<h1>Edit Profile</h1>
		</div>
		<div class="genpage-wrapper">
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<div class="user-profile-photo">
					<?php
					if($user_data['profile_pic'] != ''){
						$image = Router::url("/uploads/user_profile_pic/thumb/", true).$user_data['profile_pic'];
					}else{
						$image = Router::url("/images/", true).'user.png';
					}
					?>
						<figure><img src="<?php echo $image; ?>" alt="" id='img_to_show' /></figure>
					<?php
					if($user_data['type'] == 'N'){	//for normal users (not logged in using social media)
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
						<h3>Public Information</h3>
						<div id="edit_profile_msg"><?php echo $this->Flash->render();?></div>
						<div class="edit-details-from-wrapper">
							<?php echo $this->Form->create(false,['url'=>'javascript:void(0)', 'id'=>'edit_profile_form', 'class'=>'edit_profile_form', 'novalidate' => 'novalidate']); ?>
								<div class="row form-row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Your Name or Nick Name</label>
											<?php echo $this->Form->input('name',['type'=>'text', 'placeholder'=>'Your Name or Nick Name', 'label'=>false, 'class'=>'form-control', 'required'=>"required"]); ?>
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Location</label>
											<?php echo $this->Form->input('location',['type'=>'text', 'placeholder'=>'Location', 'label'=>false, 'class'=>'form-control']); ?>
										</div>
									</div>
								</div>
								<div class="row from-row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Title</label>
											<?php echo $this->Form->input('title',['type'=>'text', 'placeholder'=>'Title', 'label'=>false, 'class'=>'form-control']); ?>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group">
										<label for="">About Me</label>
										<?php echo $this->Form->input('about_me',['type'=>'textarea', 'placeholder'=>'Title', 'label'=>false, 'class'=>'form-control']); ?>										
									</div>
								</div>
								<br>
								<hr>
								<br>
								<h3>Web Preference</h3>
								<div class="row form-row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Facebook Link</label>
											<?php echo $this->Form->input('facebook_link',['type'=>'text', 'placeholder'=>'Facebook Link', 'label'=>false, 'class'=>'form-control']); ?>
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Twitter Link</label>
											<?php echo $this->Form->input('twitter_link',['type'=>'text', 'placeholder'=>'Twitter Link', 'label'=>false, 'class'=>'form-control']); ?>
										</div>
									</div>
								</div>
								<div class="row form-row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Google Plus Link</label>
											<?php echo $this->Form->input('gplus_link',['type'=>'text', 'placeholder'=>'Google Plus Link', 'label'=>false, 'class'=>'form-control']); ?>
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Linkedin Link</label>
											<?php echo $this->Form->input('linkedin_link',['type'=>'text', 'placeholder'=>'Linkedin Link', 'label'=>false, 'class'=>'form-control']); ?>
										</div>
									</div>
								</div>
								<br>
								<hr>
								<br>
								<h3>Career & Education History</h3>
								<div class="work-detail-tabs">
									<ul class="tabs">
										<li class="tab-link current" data-tab="tab-1">
										<?php
										if( count($education_details) > 0 ) {
											echo $this->Form->input('education_chk', ['type'=>'checkbox', 'id'=>'education_chk', 'label' => ' Education	', 'class' => '', 'required'=>false, 'div' => false, 'value' => 'education', 'autocomplete' => 'off', 'checked']);
										}else{
											echo $this->Form->input('education_chk', ['type'=>'checkbox', 'id'=>'education_chk', 'label' => ' Education', 'class' => '', 'required'=>false, 'div' => false, 'value' => 'education', 'autocomplete' => 'off']);
										}
										?>
										</li>
										<li class="tab-link" data-tab="tab-2">
										<?php
										if( count($career_details) > 0 ) {
											echo $this->Form->input('career_chk', ['type'=>'checkbox', 'id'=>'career_chk', 'label' => ' Career', 'class' => '', 'required'=>false, 'div' => false, 'value' => 'career', 'autocomplete' => 'off', 'checked']);
										}else{
											echo $this->Form->input('career_chk', ['type'=>'checkbox', 'id'=>'career_chk', 'label' => ' Career', 'class' => '', 'required'=>false, 'div' => false, 'value' => 'career', 'autocomplete' => 'off']);
										}
										?>
										</li>
									</ul>
									
									<div id="education_div" style="<?php if( count($education_details) > 0 ) echo 'display:block;'; else echo 'display:none;' ?>">
										<div class="box-body pad" id="education_div_more">
											<label for="">Educational Details</label>
									<?php
									if(!empty($education_details)){
										$b=0;
										foreach($education_details as $key_edu_detail => $val_edu_detail){
									?>
											<div id="education_id_<?php echo $key_edu_detail; ?>">												
												<div class="row form-row" style="position:relative;">
													<input type="hidden" id="edu_id_<?php echo $b; ?>" name="education[<?php echo $b; ?>][id]" value="<?php echo $key_edu_detail; ?>" />
													<div class="col-md-6">
														<div class="form-inline">									  
															<div class="input-group mb-2 mr-sm-2 education_width">
																<label class="sr-only" for="inlineFormInput"> Degree, certificate, or completion / finished</label>
																<input type="text" class="form-control mb-2 mr-sm-2" id="edu_degree_<?php echo $b; ?>" name="education[<?php echo $b; ?>][edu_degree]" value="<?php echo $val_edu_detail['edu_degree']; ?>" required placeholder="Degree, certificate, or completion / finished" title="Degree, certificate, or completion / finished">
															</div>
															<div class="input-group mb-2 mr-sm-2 education_width education_margin">
															  <div class="input-group-addon">at</div>
															  <input type="text" class="form-control" id="edu_organization_<?php echo $b; ?>" name="education[<?php echo $b; ?>][edu_organization]" value="<?php echo $val_edu_detail['edu_organization']; ?>" required placeholder="School, bootcamp, MOOC, course or similar name" title="School, bootcamp, MOOC, course or similar name">
															</div>
														</div>
													</div>									
													<div class="col-md-6">
														<div class="form-inline">									  
															<div class="input-group mb-2 mr-sm-2 education_width">
																<input type="text" id="edu_from_<?php echo $b; ?>" required name="education[<?php echo $b; ?>][edu_from]"  value="<?php echo date('m/d/Y', strtotime($val_edu_detail['edu_from']));?>" class="form-control mr-sm-2" data-provide="datepicker" placeholder="From date" title="From date">
															</div>										
															<div class="input-group mb-2 mr-sm-2 education_width">
																<input type="text" id="edu_to_<?php echo $b; ?>" required name="education[<?php echo $b; ?>][edu_to]" value="<?php echo date('m/d/Y', strtotime($val_edu_detail['edu_to']));?>" class="form-control" placeholder="To date" data-provide="datepicker" title="To date">
															</div>										
														</div>
													</div>
													<span onclick="ajax_delete_careereducation('<?php echo base64_encode($user_related_details['id']);?>','<?php echo base64_encode($key_edu_detail);?>','<?php echo base64_encode('E');?>');" title="Delete" class="remove_minus"><i class="fa fa-trash-o"></i></span>
												</div>
											</div>
									<?php
										$b++;
										}
									}else{
									?>
											<div id="education_id_0">												
												<div class="row form-row" style="position:relative;">
													<input type="hidden" id="edu_id_0" name="education[0][id]" value="" />
													<div class="col-md-6">
														<div class="form-inline">									  
															<div class="input-group mb-2 mr-sm-2 education_width">
																<label class="sr-only" for="inlineFormInput"> Degree, certificate, or completion / finished</label>
																<input type="text" class="form-control mb-2 mr-sm-2" id="edu_degree_0" name="education[0][edu_degree]" required placeholder="Degree, certificate, or completion / finished" title="Degree, certificate, or completion / finished">
															</div>
															<div class="input-group mb-2 mr-sm-2 education_width education_margin">
															  <div class="input-group-addon">at</div>
															  <input type="text" class="form-control" id="edu_organization_0" name="education[0][edu_organization]" required placeholder="School, bootcamp, MOOC, course or similar name" title="School, bootcamp, MOOC, course or similar name">
															</div>
														</div>
													</div>									
													<div class="col-md-6">
														<div class="form-inline">									  
															<div class="input-group mb-2 mr-sm-2 education_width">
																<input type="text" id="edu_from_0" required name="education[0][edu_from]" class="form-control mr-sm-2" data-provide="datepicker" placeholder="From date" title="From date">
															</div>										
															<div class="input-group mb-2 mr-sm-2 education_width">
															  <input type="text" id="edu_to_0" required name="education[0][edu_to]" class="form-control" placeholder="To date" data-provide="datepicker" title="To date">
															</div>										
														</div>
													</div>
												</div>
											</div>
									<?php
									}
									?>
										</div>
										<button type="button" class="btn more-files1" id="add_more_education"><i class="fa fa-plus"></i>&nbsp;&nbsp;More</button>
									</div>
									
									<div id="career_div" style="<?php if( count($career_details) > 0 ) echo 'display:block;'; else echo 'display:none;';?>">
										<div class="box-body pad" id="career_div_more">
											<label for="">Company Details</label>
									<?php
									if(!empty($career_details)){
										$c=0;
										foreach($career_details as $key_career_detail => $val_career_detail){
									?>
											<div id="career_id_<?php echo $key_career_detail; ?>">
												<div class="row form-row" style="position:relative;">
													<input type="hidden" id="car_id_<?php echo $c; ?>" name="career[<?php echo $c; ?>][id]" value="<?php echo $key_career_detail; ?>" />
													<div class="col-md-6">
														<div class="form-inline">									  
															<div class="input-group mb-2 mr-sm-2 career_width">
																<label class="sr-only" for="inlineFormInput">Position</label>
																<input type="text" class="form-control mb-2 mr-sm-2" id="career_position_<?php echo $c; ?>" name="career[<?php echo $c; ?>][career_position]" value="<?php echo $val_career_detail['career_position']; ?>" required placeholder="Position" title="Position">
															</div>
															<div class="input-group mb-2 mr-sm-2 career_width career_margin">
																<div class="input-group-addon">at</div>
																<input type="text" class="form-control" id="career_company_<?php echo $c; ?>" name="career[<?php echo $c; ?>][career_company]" value="<?php echo $val_career_detail['career_company']; ?>" required placeholder="Company Name" title="Company Name">
															</div>
														</div>
													</div>									
													<div class="col-md-6">
														<div class="form-inline">									  
															<div class="input-group mb-2 mr-sm-2 career_width">
																<input type="text" id="career_from_<?php echo $c; ?>" required name="career[<?php echo $c; ?>][career_from]" value="<?php echo date('m/d/Y', strtotime($val_career_detail['career_from']));?>" class="form-control mr-sm-2" data-provide="datepicker" placeholder="From date" title="From date">
															</div>										
															<div class="input-group mb-2 mr-sm-2 career_width">
																<input type="text" id="career_to_<?php echo $c; ?>" required name="career[<?php echo $c; ?>][career_to]" value="<?php echo date('m/d/Y', strtotime($val_career_detail['career_to']));?>" class="form-control" placeholder="To date" data-provide="datepicker" title="To date">
															</div>										
														</div>
													</div>
													<span onclick="ajax_delete_careereducation('<?php echo base64_encode($user_related_details['id']);?>','<?php echo base64_encode($key_career_detail);?>','<?php echo base64_encode('C');?>');" title="Delete" class="remove_minus"><i class="fa fa-trash-o"></i></span>
												</div>
											</div>
									<?php
										$c++;
										}
									}else{
									?>
											<div id="career_id_0">
												<div class="row form-row" style="position:relative;">
													<input type="hidden" id="car_id_0" name="career[0][id]" value="" />
													<div class="col-md-6">
														<div class="form-inline">									  
															<div class="input-group mb-2 mr-sm-2 career_width">
																<label class="sr-only" for="inlineFormInput">Position</label>
																<input type="text" class="form-control mb-2 mr-sm-2" id="career_position_0" name="career[0][career_position]" required placeholder="Position" title="Position">
															</div>
															<div class="input-group mb-2 mr-sm-2 career_width career_margin">
															  <div class="input-group-addon">at</div>
															  <input type="text" class="form-control" id="career_company_0" name="career[0][career_company]" required placeholder="Company Name" title="Company Name">
															</div>
														</div>
													</div>									
													<div class="col-md-6">
														<div class="form-inline">									  
															<div class="input-group mb-2 mr-sm-2 career_width">
																<input type="text" id="career_from_0" required name="career[0][career_from]" class="form-control mr-sm-2" data-provide="datepicker" placeholder="From date" title="From date">
															</div>										
															<div class="input-group mb-2 mr-sm-2 career_width">
															  <input type="text" id="career_to_0" required name="career[0][career_to]" class="form-control" placeholder="To date" data-provide="datepicker" title="To date">
															</div>										
														</div>
													</div>
												</div>
											</div>
									<?php
									}
									?>
										</div>
										<button type="button" class="btn more-files1" id="add_more_career"><i class="fa fa-plus"></i>&nbsp;&nbsp;More</button>
									</div>
								</div>
							   <br>
							   <hr>
							   <br>							  
								<h3>Private Information</h3>
								<div class="row form-row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Full Name</label>
											<?php echo $this->Form->input('full_name',['type'=>'text', 'placeholder'=>'Full Name', 'label'=>false, 'class'=>'form-control']); ?>
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Email</label>
											<?php echo $this->Form->input('email',['type'=>'email', 'placeholder'=>'Email', 'label'=>false, 'class'=>'form-control', 'readonly']); ?>
										</div>
									</div>
								</div>
								<div class="row form-row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<label for="">Birthday</label>
											<?php
											if($user_related_details['birthday']!='' && $user_related_details['birthday']!=NULL){
												$dob = date('m/d/Y', strtotime($user_related_details['birthday']));
												echo $this->Form->input('birthday',['type'=>'text', 'id'=>'birthday', 'placeholder'=>'mm/dd/yyyy', 'label'=>false, 'class'=>'form-control', 'value'=>$dob, 'required'=>'required']);
											}else{
												echo $this->Form->input('birthday',['type'=>'text', 'id'=>'birthday', 'placeholder'=>'mm/dd/yyyy', 'label'=>false, 'class'=>'form-control', 'value'=>'', 'required'=>'required']);
											}
											?>
										</div>
									</div>								
								</div>
								<div class="button-set">								
									<input type="submit" value="Save Profile" class="btn-normal">									
								</div>							  
							<?php echo $this->Form->end();?>
							<div id="edit_profile_error_msg"></div>
							<div id="edit_profile_loader" style="text-align:center;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<script>
$(document).ready(function(){
	setTimeout(function(){
		$('#msg_div').html('');
		$('#profile_msg').html('');
		$('#edit_profile_msg').html('');
	},5000);
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
	        	var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Error uploading picture, please try again later with jpg/jpeg.</div>";
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
	        var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Error uploading picture, please try again later with jpg/jpeg.</div>";
			$('#profile_msg').html(msg);     
	    }
	});
});


$('#edit_profile_form').validate({
	submitHandler:function(){
		$('#edit_profile_loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var data = $('#edit_profile_form').serialize();
		var promise = $.post('<?php echo Router::url("/users/update-profile/",true); ?>',data);
		promise.done(function(response){
			$('#edit_profile_loader').html('');
			var data = JSON.parse(response);
			if(data.edit_profile == 'success'){
				window.location.href = '<?php echo Router::url(array('controller'=>'Users','action'=>'edit-profile'),true); ?>';
			}else{
				$('#edit_profile_loader').html('');
				var edit_profile_msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
				$('#edit_profile_error_msg').html(edit_profile_msg);
				setTimeout(function(){
					$('#edit_profile_error_msg').html('');
				},5000);
			}
		});
		promise.fail(function(){
			$('#edit_profile_loader').html('');
			var edit_profile_msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
			$('#edit_profile_error_msg').html(edit_profile_msg);
			setTimeout(function(){
				$('#edit_profile_error_msg').html('');
			},5000);
		});
	}
});

//education section start here//
$("#education_chk").click(function(){
	if ($('#education_chk').is(":checked")) {
		$("#education_div").show(500);
	} else {
		$("#education_div").hide(500);
	}
});

<?php
if( count($education_details) > 0 ) {
?>
	var education_count = <?php echo count($education_details);?>;
<?php
}else{
?>	
	var education_count = 0;
<?php
}

if( count($career_details) > 0 ) {
?>
	var career_count = <?php echo count($career_details);?>;
<?php
}else{
?>	
	var career_count = 0;
<?php
}
?>
$('#add_more_education').click(function(){
	education_count += 1;	 
	$('#education_div_more').append(
			'<div id="education_id_'+education_count+'" style="margin:5px 5px 0 0;">'+
				'<div class="row form-row" style="position:relative;">'+
					'<input type="hidden" id="edu_id_'+education_count+'" name="education['+education_count+'][id]" value="" />'+
					'<div class="col-md-6">'+
						'<div class="form-inline">'+
							'<div class="input-group mb-2 mr-sm-2 education_width">'+
								'<label class="sr-only" for="inlineFormInput"> Degree, certificate, or completion / finished</label>'+
								'<input type="text" class="form-control mb-2 mr-sm-2" id="edu_degree_'+education_count+'" name="education['+education_count+'][edu_degree]" required placeholder="Degree, certificate, or completion / finished" title="Degree, certificate, or completion / finished">'+
							'</div>'+
							'<div class="input-group mb-2 mr-sm-2 education_width education_margin">'+
							  '<div class="input-group-addon">at</div>'+
							  '<input type="text" class="form-control" id="edu_organization_'+education_count+'" name="education['+education_count+'][edu_organization]" required placeholder="School, bootcamp, MOOC, course or similar name" title="School, bootcamp, MOOC, course or similar name">'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<div class="col-md-6">'+
						'<div class="form-inline">'+
							'<div class="input-group mb-2 mr-sm-2 education_width">'+
								'<input type="text" id="edu_from_'+education_count+'" required name="education['+education_count+'][edu_from]" class="form-control mr-sm-2" data-provide="datepicker" placeholder="From date" title="From date">'+
							'</div>'+
							'<div class="input-group mb-2 mr-sm-2 education_width">'+
							  '<input type="text" id="edu_to_'+education_count+'" required name="education['+education_count+'][edu_to]" class="form-control" placeholder="To date" data-provide="datepicker" title="To date">'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<span onclick="close_education('+education_count+');" title="Delete" class="remove_minus"><i class="fa fa-trash-o"></i></span>'+
				'</div>'+
			'</div>');
	var edu_from = $( '#edu_from_'+education_count ).datepicker({'maxDate': 0}).on('change', function(){
		edu_to.datepicker( "option", "minDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
	var edu_to = $( '#edu_to_'+education_count ).datepicker({'maxDate': 0}).on('change', function(){
		edu_from.datepicker( "option", "maxDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
});
$(document).ready(function(){
<?php
if(!empty($education_details)){
	$h=0;
	foreach($education_details as $key_edu_detail => $val_edu_detail){
?>
	var $edu_from_<?php echo $h;?> = $( "#edu_from_<?php echo $h;?>" ).datepicker({'maxDate': 0}).on('change', function(){
		$edu_to_<?php echo $h;?>.datepicker( "option", "minDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
	var $edu_to_<?php echo $h;?> = $( "#edu_to_<?php echo $h;?>" ).datepicker({'maxDate': 0}).on('change', function(){
		$edu_from_<?php echo $h;?>.datepicker( "option", "maxDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
<?php
	$h++;
	}
}
?>
});
function close_education(ID){
	$('#edu_id_'+ID).val('');
	$('#edu_degree_'+ID).val('');
	$('#edu_organization_'+ID).val('');
	$('#edu_from_'+ID).val('');
	$('#edu_to_'+ID).val('');
	$('#education_id_'+ID).remove();
}
$(document).ready(function(){
	var $edu_from_0 = $( "#edu_from_0" ).datepicker({'maxDate': 0}).on('change', function(){
		$edu_to_0.datepicker( "option", "minDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
	var $edu_to_0 = $( "#edu_to_0" ).datepicker({'maxDate': 0}).on('change', function(){
		$edu_from_0.datepicker( "option", "maxDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
});
//education section end here//
//career_width section start here//
$("#career_chk").click(function(){	
	if ($('#career_chk').is(":checked")) {
		$("#career_div").show(500);
	} else {
		/*$("#car_id_0").val('');
		$("#career_position_0").val('');
		$("#career_company_0").val('');
		$("#career_from_0").val('');
		$("#career_to_0").val('');
		$(".career_class").each(function(){                         
			$(".career_more_class").remove();
			$(".career_class").val('');
		});*/
		$("#career_div").hide(500);
	}
});

$('#add_more_career').click(function(){
	career_count += 1;	 
	$('#career_div_more').append(
				'<div id="career_id_'+career_count+'" style="margin:5px 5px 0 0;">'+
					'<div class="row form-row" style="position:relative;">'+
						'<input type="hidden" id="car_id_'+career_count+'" name="career['+career_count+'][id]" value="" />'+
						'<div class="col-md-6">'+
							'<div class="form-inline">'+
								'<div class="input-group mb-2 mr-sm-2 career_width">'+
									'<label class="sr-only" for="inlineFormInput">Position</label>'+
									'<input type="text" class="form-control mb-2 mr-sm-2" id="career_position_'+career_count+'" name="career['+career_count+'][career_position]" required placeholder="Position" title="Position">'+
								'</div>'+
								'<div class="input-group mb-2 mr-sm-2 career_width career_margin">'+
								  '<div class="input-group-addon">at</div>'+
								  '<input type="text" class="form-control" id="career_company_'+career_count+'" name="career['+career_count+'][career_company]" required placeholder="Company Name" title="Company Name">'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="col-md-6">'+
							'<div class="form-inline">'+
								'<div class="input-group mb-2 mr-sm-2 career_width">'+
									'<input type="text" id="career_from_'+career_count+'" required name="career['+career_count+'][career_from]" class="form-control mr-sm-2" data-provide="datepicker" placeholder="From date" title="From date">'+
								'</div>'+
								'<div class="input-group mb-2 mr-sm-2 career_width">'+
									'<input type="text" id="career_to_'+career_count+'" required name="career['+career_count+'][career_to]" class="form-control" placeholder="To date" data-provide="datepicker" title="To date">'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<span onclick="close_career('+career_count+');" title="Delete" class="remove_minus"><i class="fa fa-trash-o"></i></span>'+		
					'</div>'+
				'</div>');
	var career_from = $( '#career_from_'+career_count ).datepicker({'maxDate': 0}).on('change', function(){
		career_to.datepicker( "option", "minDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
	var career_to = $( '#career_to_'+career_count ).datepicker({'maxDate': 0}).on('change', function(){
		career_from.datepicker( "option", "maxDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
});
function close_career(ID){
	$('#car_id_'+ID).val('');
	$('#career_position_'+ID).val('');
	$('#career_company_'+ID).val('');
	$('#career_from_'+ID).val('');
	$('#career_to_'+ID).val('');
	$('#career_id_'+ID).remove();
}
$(document).ready(function(){
<?php
if(!empty($career_details)){
	$v=0;
	foreach($career_details as $key_career_detail => $val_career_detail){
?>
	var $career_from_<?php echo $v;?> = $( "#career_from_<?php echo $v;?>" ).datepicker({'maxDate': 0}).on('change', function(){
		$career_to_<?php echo $v;?>.datepicker( "option", "minDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
	var $career_to_<?php echo $v;?> = $( "#career_to_<?php echo $v;?>" ).datepicker({'maxDate': 0}).on('change', function(){
		$career_from_<?php echo $v;?>.datepicker( "option", "maxDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
<?php
	$v++;
	}
}
?>
});
$(document).ready(function(){
	var $career_from_0 = $( "#career_from_0" ).datepicker({'maxDate': 0}).on('change', function(){
		$career_to_0.datepicker( "option", "minDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
	var $career_to_0 = $( "#career_to_0" ).datepicker({'maxDate': 0}).on('change', function(){
		$career_from_0.datepicker( "option", "maxDate", $.datepicker.parseDate( "mm/dd/yy", this.value ));
	});
});
//education section end here//

function ajax_delete_careereducation(id,car_edu_id,type){
	var result = confirm('Are you sure?');
	if(result){
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo Router::url("/users/ajax-delete-careereducation/",true); ?>',
			data: {user_id: id, careereducation_id: car_edu_id, careereducation_type: type},			
			success: function(result) {
				if(result.type == 'success'){
					window.location.reload();
				}
			}
		});
	}
}
$("#birthday").datepicker({
	changeMonth: true,
	changeYear: true,
	yearRange: "1950:+0",
	maxDate: 'now'
});
</script>