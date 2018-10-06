<?php use Cake\Routing\Router; $session = $this->request->session();
$this->assign('hasDatepicker', true); ?>
<style>
.checkbox{display:block;}
.education_width, .career_width{width:49% !important;}
.education_margin, .career_margin{margin-right:5px !important;}
.social_class{padding-left:0;}
.more-files1{border:1px solid #ccc; margin-bottom:0 !important;}
.more-files1:hover{color:#caa961; border:1px solid #caa961; margin-bottom:0 !important;}
.remove_minus{position:absolute; top:9px; right:0; padding-right:2px;cursor:pointer; color:#db0e1e;}
</style>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Edit User
         <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <?php echo $this->Flash->render(); //pr($user); ?>
   <?php echo $this->Form->create($user,['id' => 'login-form', 'novalidate' => 'novalidate', 'enctype'=>'multipart/form-data']); ?>
      <div class="card card-block">
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Nick Name:<span style="color:#ff0000;">*</span>
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('name', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Eg. Rasmus']); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">Profile Pic:</label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('profile_pic', ['type'=>'file', 'label' => false, 'class' => 'form-control boxed', 'accept'=>"image/*", 'onchange' => 'image_preview(event)', 'autocomplete' => 'off']); ?>
               <p class="error_msg"></p>
               <p class="sm_txt_nm">* Please upload jpg, png, jpeg files only, for best view please add above 235px x 199px image.</p>
				<?php
				$profile_pic = '';
				if($user->profile_pic !=''){
					$profile_pic = $user->profile_pic;
					$profile_pic = Router::url('/uploads/user_profile_pic/thumb/', true).$profile_pic;
				}else{
					/*$profile_pic = 'user.png';
					$profile_pic = Router::url('/images/', true).$profile_pic;*/
				}
				?>
				<span id="pro_pic">
				<?php if($user->profile_pic !=''){ ?>
					<img src="<?php echo $profile_pic; ?>" width='75' height='75' style="border:1px solid #000; padding:5px;" />
					<span onclick="delete_profilepic('<?php echo base64_encode($user->id);?>');" title="Delete" style="color:#db0e1e; cursor:pointer;"><i class="fa fa-trash-o"></i></span>
				<?php } ?>
				</span>
				<output id='image_view' style="padding-top:0px;"></output>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Location:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('location', ['required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Eg. Rasmus']); ?>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Title:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('title', ['required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Eg. Lerdorf']); ?>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Email:<span style="color:#ff0000;">*</span><br /><span style="color:#ff0000;font-weight:normal;font-size:14px;">(Private)</span>
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('email', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Eg. example@example.com']); ?>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Full Name:<br /><span style="color:#ff0000;font-weight:normal;font-size:14px;">(Private)</span>
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('full_name', ['required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Eg. SF89GH']); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Date of birth:<br /><span style="color:#ff0000;font-weight:normal;font-size:14px;">(Private)</span>
            </label>
            <div class="col-sm-3">
			<?php			
			if($user->birthday != '' && $user->birthday != '0000-00-00') {
				echo $this->Form->input('birthday', ['type' => 'text', 'id' => 'birthday', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Date of birth', 'value' => date('m/d/Y',strtotime($user->birthday))]);
            }else{
				echo $this->Form->input('birthday', ['type' => 'text', 'id' => 'birthday', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Date of birth', 'value' => '']);
			}	
			?>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               About:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('about_me', ['type'=>'textarea', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'About me' ]); ?>
            </div>
         </div>
		 
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">Web Preference :</label>
			<div class="col-sm-10">
				<div class="col-sm-6 social_class">
					<div>Facebook Link
				   <?php echo $this->Form->input('facebook_link', ['type'=>'text', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Facebook Link' ]); ?>
					</div>
				</div>
				<div class="col-sm-6 social_class">
					<div>Twitter Link
				   <?php echo $this->Form->input('twitter_link', ['type'=>'text', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Twitter Link' ]); ?>
					</div>
				</div>
				<div style="clear:both;">&nbsp;</div>
				<div class="col-sm-6 social_class">
					<div>GPlus Link
				   <?php echo $this->Form->input('gplus_link', ['type'=>'text', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'GPlus Link' ]); ?>
					</div>
				</div>
				<div class="col-sm-6 social_class">
					<div>LinkedIn Link
				   <?php echo $this->Form->input('linkedin_link', ['type'=>'text', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'LinkedIn Link' ]); ?>
					</div>
				</div>
			</div>
			<div style="clear:both;">&nbsp;</div>
		 
			<div class="form-group row">
				<label class="col-sm-2 form-control-label text-xs-right">
				   Career & Education History:
				</label>
				<div class="col-sm-10">
					<div class="form-group row">
						<div class="col-sm-2">
							<?php
							if( count($education_details) > 0 ) {
								echo $this->Form->input('education_chk', ['type'=>'checkbox', 'id'=>'education_chk', 'label' => ' Education', 'class' => '', 'required'=>false, 'div' => false, 'value' => 'education', 'autocomplete' => 'off', 'checked']);
							}else{
								echo $this->Form->input('education_chk', ['type'=>'checkbox', 'id'=>'education_chk', 'label' => ' Education', 'class' => '', 'required'=>false, 'div' => false, 'value' => 'education', 'autocomplete' => 'off']);
							}
							?>
						</div>
						<div class="col-sm-2">
							<?php
							if( count($career_details) > 0 ) {
								echo $this->Form->input('career_chk', ['type'=>'checkbox', 'id'=>'career_chk', 'label' => ' Career', 'class' => '', 'required'=>false, 'div' => false, 'value' => 'career', 'autocomplete' => 'off', 'checked']);
							}else{
								echo $this->Form->input('career_chk', ['type'=>'checkbox', 'id'=>'career_chk', 'label' => ' Career', 'class' => '', 'required'=>false, 'div' => false, 'value' => 'career', 'autocomplete' => 'off']);
							}
							?>
						</div>
					 </div>
					<div id="education_div" style="<?php if( count($education_details) > 0 ) echo 'display:block;'; else echo 'display:none;' ?> border:1px solid #ccc; padding:10px 10px;">
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
									<div class="col-md-12">
									  <div class="form-inline">
										<div class="input-group mb-2 mr-sm-2 education_width">
											<label class="sr-only" for="inlineFormInput"> Degree, certificate, or completion / finished</label>
											<input type="text" class="form-control mb-2 mr-sm-2" id="edu_degree_<?php echo $b; ?>" name="education[<?php echo $b; ?>][edu_degree]" value="<?php echo $val_edu_detail['edu_degree']; ?>" required placeholder="Degree, certificate, or completion / finished" title="Degree, certificate, or completion / finished">
										</div>
										<div class="input-group mb-2 mr-sm-2 education_width">
										  <div class="input-group-addon">at</div>
										  <input type="text" class="form-control" id="edu_organization_<?php echo $b; ?>" name="education[<?php echo $b; ?>][edu_organization]" value="<?php echo $val_edu_detail['edu_organization']; ?>" required placeholder="School, bootcamp, MOOC, course or similar name" title="School, bootcamp, MOOC, course or similar name">
										</div>
									  </div>
									</div>									
									<div class="col-md-12">
										<div class="form-inline">									  
											<div class="input-group mb-2 mr-sm-2 education_width">
												<input type="text" id="edu_from_<?php echo $b; ?>" required name="education[<?php echo $b; ?>][edu_from]"  value="<?php echo date('m/d/Y', strtotime($val_edu_detail['edu_from']));?>" class="form-control mr-sm-2" data-provide="datepicker" placeholder="From date" title="From date">
											</div>										
											<div class="input-group mb-2 mr-sm-2 education_width">
											  <input type="text" id="edu_to_<?php echo $b; ?>" required name="education[<?php echo $b; ?>][edu_to]" value="<?php echo date('m/d/Y', strtotime($val_edu_detail['edu_to']));?>" class="form-control" placeholder="To date" data-provide="datepicker" title="To date">
											</div>										
										  </div>									
									</div>
									<span onclick="ajax_delete_careereducation('<?php echo base64_encode($user->id);?>','<?php echo base64_encode($key_edu_detail);?>','<?php echo base64_encode('E');?>');" title="Delete" class="remove_minus"><i class="fa fa-trash-o"></i></span>
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
									<div class="col-md-12">
									  <div class="form-inline">									  
										<div class="input-group mb-2 mr-sm-2 education_width">
											<label class="sr-only" for="inlineFormInput"> Degree, certificate, or completion / finished</label>
											<input type="text" class="form-control mb-2 mr-sm-2" id="edu_degree_0" name="education[0][edu_degree]" required placeholder="Degree, certificate, or completion / finished" title="Degree, certificate, or completion / finished">
										</div>
										<div class="input-group mb-2 mr-sm-2 education_width">
										  <div class="input-group-addon">at</div>
										  <input type="text" class="form-control" id="edu_organization_0" name="education[0][edu_organization]" required placeholder="School, bootcamp, MOOC, course or similar name" title="School, bootcamp, MOOC, course or similar name">
										</div>
									  </div>
									</div>									
									<div class="col-md-12">
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
					
					<div id="career_div" style="<?php if( count($career_details) > 0 ) echo 'display:block;'; else echo 'display:none;' ?> border:1px solid #ccc; padding:10px 10px; margin-top:10px;">
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
									<div class="col-md-12">
									  <div class="form-inline">									  
										<div class="input-group mb-2 mr-sm-2 career_width">
											<label class="sr-only" for="inlineFormInput">Position</label>
											<input type="text" class="form-control mb-2 mr-sm-2" id="career_position_<?php echo $c; ?>" name="career[<?php echo $c; ?>][career_position]" value="<?php echo $val_career_detail['career_position']; ?>" required placeholder="Position" title="Position">
										</div>
										<div class="input-group mb-2 mr-sm-2 career_width">
										  <div class="input-group-addon">at</div>
										  <input type="text" class="form-control" id="career_company_<?php echo $c; ?>" name="career[<?php echo $c; ?>][career_company]" value="<?php echo $val_career_detail['career_company']; ?>" required placeholder="Company Name" title="Company Name">
										</div>
									  </div>
									</div>									
									<div class="col-md-12">
										<div class="form-inline">
											<div class="input-group mb-2 mr-sm-2 career_width">
												<input type="text" id="career_from_<?php echo $c; ?>" required name="career[<?php echo $c; ?>][career_from]" value="<?php echo date('m/d/Y', strtotime($val_career_detail['career_from']));?>" class="form-control mr-sm-2" data-provide="datepicker" placeholder="From date" title="From date">
											</div>										
											<div class="input-group mb-2 mr-sm-2 career_width">
											  <input type="text" id="career_to_<?php echo $c; ?>" required name="career[<?php echo $c; ?>][career_to]" value="<?php echo date('m/d/Y', strtotime($val_career_detail['career_to']));?>" class="form-control" placeholder="To date" data-provide="datepicker" title="To date">
											</div>										
										  </div>					
									</div>
									<span onclick="ajax_delete_careereducation('<?php echo base64_encode($user->id);?>','<?php echo base64_encode($key_career_detail);?>','<?php echo base64_encode('C');?>');" title="Delete" class="remove_minus"><i class="fa fa-trash-o"></i></span>
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
									<div class="col-md-12">
									  <div class="form-inline">									  
										<div class="input-group mb-2 mr-sm-2 career_width">
											<label class="sr-only" for="inlineFormInput">Position</label>
											<input type="text" class="form-control mb-2 mr-sm-2" id="career_position_0" name="career[0][career_position]" required placeholder="Position" title="Position">
										</div>
										<div class="input-group mb-2 mr-sm-2 career_width">
										  <div class="input-group-addon">at</div>
										  <input type="text" class="form-control" id="career_company_0" name="career[0][career_company]" required placeholder="Company Name" title="Company Name">
										</div>
									  </div>
									</div>									
									<div class="col-md-12">
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
			</div>
			<?php //pr($user); ?>
			<div class="form-group row">
				<label class="col-sm-2 form-control-label text-xs-right">
				   &nbsp;
				</label>
				<div class="col-sm-10">
					<?php
					$pers_checked_button = '';
					if($user['personal_data']=='Y'){
						$pers_checked_button = 'checked';
					}
					?>
					<input type="checkbox" id="personal_data" name="personal_data" value="Y" <?php echo $pers_checked_button;?> autocomplete="off">
					<label for="personal_data" title="I agree with sending commercial communications about LearnerOn.net service by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time.">
						I agree with sending LearnerOn.net commercial communication and processing my personal data&nbsp;
						<!--<img src="<?php echo Router::url('/images/info-icon.png');?>" data-toggle="tooltip_personaldata" data-original-title="I agree with sending commercial communications about LearnerOn.net service by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time." />-->
					</label>
					<br />
					<?php
					//pr($user); die;
					?>
					<b>Checked Time:</b> <?php if($user->personaldata_checked_time != '' && $user->personaldata_checked_time != '0000-00-00 00:00:00')echo date('dS M Y H:i:s',strtotime($user->personaldata_checked_time));else echo 'N/A'; ?>, <b>Unchecked Time:</b> <?php if($user->personaldata_unchecked_time != '' && $user->personaldata_unchecked_time != '0000-00-00 00:00:00')echo date('dS M Y H:i:s',strtotime($user->personaldata_unchecked_time));else echo 'N/A'; ?>
				</div>
			 </div>
			 
			 <div class="form-group row">
				<label class="col-sm-2 form-control-label text-xs-right">
				   &nbsp;
				</label>
				<div class="col-sm-10">
					<?php
					$commer_checked_button = '';
					if($user['is_commercialparty']=='1'){
						$commer_checked_button = 'checked';
					}
					?>					
					<input type="checkbox" id="is_commercialparty" name="is_commercialparty" value="1" <?php echo $commer_checked_button;?> autocomplete="off">
					<label for="is_commercialparty" title="I agree with sending third-party commercial communications by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time.">
						I agree with sending 3rd party commercial communication by Learneron, SE and processing my personal data&nbsp;
						<!--<img src="<?php echo Router::url('/images/info-icon.png');?>" data-toggle="tooltip" data-original-title="I agree with sending third-party commercial communications by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time." />-->
					</label>
					<br />
					<?php
					//pr($user); die;
					?>
					<b>Checked Time:</b> <?php if($user->commercialparty_checked_time != '' && $user->commercialparty_checked_time != '0000-00-00 00:00:00')echo date('dS M Y H:i:s',strtotime($user->commercialparty_checked_time));else echo 'N/A'; ?>, <b>Unchecked Time:</b> <?php if($user->commercialparty_unchecked_time != '' && $user->commercialparty_unchecked_time != '0000-00-00 00:00:00')echo date('dS M Y H:i:s',strtotime($user->commercialparty_unchecked_time));else echo 'N/A'; ?>
				</div>
			 </div>
			
		<?php
		if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('Users')))) && $session->read('permissions.'.strtolower('Users').'.'.strtolower('change-status'))==1 ){
		?>
			<div class="form-group row">
				<label class="col-sm-2 form-control-label text-xs-right">Status:</label>
				<div class="col-sm-2">
					<?php echo $this->Form->input('status', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Status', 'options' => ['A' => 'Active', 'I' => 'Inactive']]); ?>
				</div>
			</div>
		<?php
		}
		?>
			<div class="form-group row">
				<div class="col-sm-10 col-sm-offset-2">
				   <?php echo $this->Form->button('Update',['type' => 'submit','class' => 'btn btn-primary']); ?>&nbsp;
				<a href="<?php echo Router::url('/admin/users/list-data',true); ?>" class="btn btn-primary">Cancel</a>
				</div>
			</div>
      </div>
   <?php echo $this->Form->end(); ?>
</article>
<script>
$('[data-toggle="tooltip"]').tooltip({
	placement : 'top'
});
$('[data-toggle="tooltip_personaldata"]').tooltip({
	placement : 'top'
});
</script>
<script>
function image_preview(evt){
	var files = evt.target.files;
	var num = 0;
	$('.preview_image').remove();
	$('.remove_preview_image').remove();
	
	// Loop through the FileList and render image files as thumbnails.
	for (var i = 0, f; f = files[i]; i++) {
		// Only process image files.
		if (!f.type.match('image.*')) {
			$('.error_msg').html('Please upload valid image file').css({'color':'red'});
			$('#image').val('');
			continue;
		}
		var reader = new FileReader();
		// Closure to capture the file information.
		reader.onload = (function(theFile) {
			return function(e) {				
				// Render thumbnail.
				var span = document.createElement('span');
				
				var uploaded_file_name = escape(theFile.name);
				var uploaded_file_extension = uploaded_file_name.substring(uploaded_file_name.lastIndexOf('.')+1);
				
				if(uploaded_file_extension=='png' || uploaded_file_extension=='jpg' || uploaded_file_extension=='jpeg' || uploaded_file_extension=='JPEG'){
					$('.error_msg').html('');
					span.innerHTML = 
						[
						'<img class="hide_shown_image preview_image" style="width: 75px; height:75px; border: 1px solid #000; margin: 5px; padding: 5px" src="', 
						e.target.result,
						'" title="', escape(theFile.name), 
						'"/><a class="remove_preview_image remove" href="javascript:remove_image();"  style="color:#db0e1e;"><i class="fa fa-trash-o "></i></a>'
						].join('');			
				}else{
					$('.error_msg').html('Please upload valid image file').css({'color':'red'});
					$('#profile-pic').val('');
				}
				document.getElementById('image_view').insertBefore(span, null);
			};
		})(f);
		// Read in the image file as a data URL.
		reader.readAsDataURL(f);
	}
}
function remove_image(){
	$('output#image_view span').remove();
	$('#profile-pic').val('');
}
$(document).ready(function(){
    var $birthday = $( "#birthday" ).datepicker({'maxDate': 0, changeMonth: true, changeYear: true,	yearRange: "1950:+0"}).on('change', function(){
      //$birthday.datepicker( "option", "minDate", $.datepicker.parseDate( "mm/dd/YY", this.value ));
    });
});

//education section start here//
$("#education_chk").click(function(){
	if ($('#education_chk').is(":checked")) {
		$("#education_div").show(500);
	} else {
		/*$("#edu_id_0").val('');
		$("#edu_degree_0").val('');
		$("#edu_organization_0").val('');
		$("#edu_from_0").val('');
		$("#edu_to_0").val('');
		$(".education_class").each(function(){                         
			$(".education_more_class").remove();
			$(".education_class").val('');
		});*/
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
						'<div class="col-md-12">'+
						  '<div class="form-inline">'+						  
							'<div class="input-group mb-2 mr-sm-2 education_width education_margin">'+
								'<label class="sr-only" for="inlineFormInput"> Degree, certificate, or completion / finished</label>'+
								'<input type="text" class="form-control mb-2 mr-sm-2" id="edu_degree_'+education_count+'" name="education['+education_count+'][edu_degree]" required placeholder="Degree, certificate, or completion / finished" title="Degree, certificate, or completion / finished">'+
							'</div>'+
							'<div class="input-group mb-2 mr-sm-2 education_width">'+
								'<div class="input-group-addon">at</div>'+
								'<input type="text" class="form-control" id="edu_organization_'+education_count+'" name="education['+education_count+'][edu_organization]" required placeholder="School, bootcamp, MOOC, course or similar name" title="School, bootcamp, MOOC, course or similar name">'+
							'</div>'+
						  '</div>'+
						'</div>'+
						'<div class="col-md-12">'+
							'<div class="form-inline">'+
								'<div class="input-group mb-2 mr-sm-2 education_width education_margin">'+
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
						'<div class="col-md-12">'+
						  '<div class="form-inline">'+
							'<div class="input-group mb-2 mr-sm-2 career_width career_margin">'+
								'<label class="sr-only" for="inlineFormInput">Position</label>'+
								'<input type="text" class="form-control mb-2 mr-sm-2" id="career_position_'+career_count+'" name="career['+career_count+'][career_position]" required placeholder="Position" title="Position">'+
							'</div>'+
							'<div class="input-group mb-2 mr-sm-2 career_width">'+
							  '<div class="input-group-addon">at</div>'+
							  '<input type="text" class="form-control" id="career_company_'+career_count+'" name="career['+career_count+'][career_company]" required placeholder="Company Name" title="Company Name">'+
							'</div>'+
						  '</div>'+
						'</div>'+
						'<div class="col-md-12">'+
							'<div class="form-inline">'+
								'<div class="input-group mb-2 mr-sm-2 career_width career_margin">'+
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

//delete profile-pic start here//
function delete_profilepic(id){
	swal({
	  title: "Are you sure?",
	  type: "error",
	  showCancelButton: true,
	  closeOnConfirm: false,
	  confirmButtonClass: 'btn-danger',
	  confirmButtonText: "Yes",
	  showLoaderOnConfirm: true
	}, function () {
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo Router::url("/admin/users/delete-profilepic/",true); ?>',
			data: {id: id},
			success: function(result) {
				if(result.type == 'success'){
					setTimeout(function () {
						$('#pro_pic').remove();
						swal({
							title: result.message,
							type: result.type,
							confirmButtonText: "OK",
							},
							function(){
								window.location.reload();
							});
					}, 200);
				}else{
					setTimeout(function () {
						swal(result.message, "", "error");
					}, 200);
				}
			}
		});
	});
}
//delete profile-pic end here//

//delete education-career start here//
function ajax_delete_careereducation(id,car_edu_id,type){
	swal({
	  title: "Are you sure?",
	  type: "error",
	  showCancelButton: true,
	  closeOnConfirm: false,
	  confirmButtonClass: 'btn-danger',
	  confirmButtonText: "Yes",
	  showLoaderOnConfirm: true
	}, function () {
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo Router::url("/admin/users/ajax-delete-careereducation/",true); ?>',
			data: {user_id: id, careereducation_id: car_edu_id, careereducation_type: type},			
			success: function(result) {
				if(result.type == 'success'){
					setTimeout(function () {
						if(type == 'E'){
							$('#education_id_'+result.careereducation_id).remove();
						}else{
							$('#career_id_'+result.careereducation_id).remove();
						}						
						swal({
							title: result.message,
							type: result.type,
							confirmButtonText: "OK",
							},
							function(){
								window.location.reload();
							});
					}, 200);
				}else{
					setTimeout(function () {
						swal(result.message, "", "error");
					}, 200);
				}
			}
		});
	});
}
//delete education-career start here//
</script>