<?php
use Cake\Routing\Router;
//pr($existing_account_settings); die;
$response_to_my_question_notification = ''; $news_notification = ''; $follow_twitter = ''; $posting_new_question_notification = ''; $category_id = '';
if(isset($existing_account_settings) && $existing_account_settings['response_to_my_question_notification']==1){
	$response_to_my_question_notification = 'checked';
}
if(isset($existing_account_settings) && $existing_account_settings['news_notification']==1){
	$news_notification = 'checked';
}
if(isset($existing_account_settings) && $existing_account_settings['follow_twitter']==1){
	$follow_twitter = 'checked';
}
if(isset($existing_account_settings) && $existing_account_settings['posting_new_question_notification']==1){
	$posting_new_question_notification = 'checked';
}
if(isset($existing_account_settings) && $existing_account_settings['category_id'] != ''){
	$category_id = $existing_account_settings['category_id'];
}
?>
<div class="genpage-user-system">
    <div class="container">
		<div class="reset-pass-box account-settings-wrapper">
			<h1>Account Settings</h1>  
			<div id="pnq_error"><?php echo $this->Flash->render();?></div>
			<?php echo $this->Form->create($account_settings,['url' => 'javascript:void(0);', 'id' => 'account-settings-form', 'novalidate' => 'novalidate']); ?>
				<div class="row">
					<div class="col-md-12">
						<label for="">Primary Email : <?php echo $user_details['email'];?></label>
					<?php if($user_details['notification_email'] != ''){ ?>
						<label for="">Notification Email : <span id="noti_email"><?php echo $user_details['notification_email'];?></span> <a href="javascript:void(0);" data-toggle="modal" data-target="#resetemail">Change Notification Email</a></label>
					<?php }else{ ?>
						<label for="">	Notification Email : <?php echo $user_details['email'];?> <a href="javascript:void(0);" data-toggle="modal" data-target="#resetemail">Change Notification Email</a></label>
					<?php } ?>
					</div>
				</div>      	   
				<div class="check-box-set">
					<input type="checkbox" id="response_to_my_question_notification" name="response_to_my_question_notification" value="1" <?php echo $response_to_my_question_notification;?> />
					<label for="response_to_my_question_notification">Receive email notifications on new responses to my questions</label>
				</div>
				<div class="check-box-set">
					<input type="checkbox" id="news_notification" name="news_notification" value="1" <?php echo $news_notification;?> />
					<label for="news_notification">Subscribe for News & Views</label>
				</div>
				<div class="check-box-set">
					<input type="checkbox" id="follow_twitter" name="follow_twitter" value="1" <?php echo $follow_twitter;?> />
					<label for="follow_twitter">Follow us on Twitter</label>
				</div>
				<div class="check-box-set">
					<input type="checkbox" id="posting_new_question_notification" name="posting_new_question_notification" value="1" <?php echo $posting_new_question_notification;?> />
					<label for="posting_new_question_notification">Send me notifications on posting new question in below defined categories</label>
				</div>
				<div class="catagory-selection">
					<select name="category_id" id="category_id">
						<option value="" disabled selected>Select your categories</option>
						<option value="">Select Catagory</option>
				<?php
				if(!empty($question_categories)){
					foreach($question_categories as $key_cat => $val_cat){
				?>
						<option value="<?php echo $key_cat;?>" <?php if($key_cat==$category_id){echo 'selected';}?>><?php echo $val_cat;?></option>
				<?php
					}
				}
				?>
					</select>
					<div id="cat_error"><?php echo $this->Flash->render();?></div>
				</div>
				
				<div class="check-box-set">
					<input type="checkbox" id="personal_data" <?php if($user_details['personal_data']=='Y')echo 'checked';?> disabled>
					<label for="personal_data" title="">
						I agree with sending LearnerOn.net commercial communication and processing my personal data&nbsp;
						<img src="<?php echo Router::url('/images/info-icon.png');?>" data-toggle="tooltip_personaldata" data-original-title="I agree with sending commercial communications about LearnerOn.net service by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time." />
					</label>
					<br />
					<span style="font-size:14px;"><b>Checked Time:</b> <?php if($user_details['personaldata_checked_time'] != '' && $user_details['personaldata_checked_time'] != '0000-00-00 00:00:00')echo date('dS M Y H:i:s',strtotime($user_details['personaldata_checked_time']));else echo 'N/A'; ?>, <b>Unchecked Time:</b> <?php if($user_details['personaldata_unchecked_time'] != '' && $user_details['personaldata_unchecked_time'] != '0000-00-00 00:00:00')echo date('dS M Y H:i:s',strtotime($user_details['personaldata_unchecked_time']));else echo 'N/A'; ?></span>
				</div>
				
				<div class="check-box-set">
					<input type="checkbox" id="is_commercialparty" <?php if($user_details['is_commercialparty']==1)echo 'checked';?> disabled>
					<label for="is_commercialparty" title="">
						I agree with sending 3rd party commercial communication by Learneron, SE and processing my personal data&nbsp;
						<img src="<?php echo Router::url('/images/info-icon.png');?>" data-toggle="tooltip" data-original-title="I agree with sending third-party commercial communications by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time." />
					</label>
					<br />
					<span style="font-size:14px;"><b>Checked Time:</b> <?php if($user_details['commercialparty_checked_time'] != '' && $user_details['commercialparty_checked_time'] != '0000-00-00 00:00:00')echo date('dS M Y H:i:s',strtotime($user_details['commercialparty_checked_time']));else echo 'N/A'; ?>, <b>Unchecked Time:</b> <?php if($user_details['commercialparty_unchecked_time'] != '' && $user_details['commercialparty_unchecked_time'] != '0000-00-00 00:00:00')echo date('dS M Y H:i:s',strtotime($user_details['commercialparty_unchecked_time']));else echo 'N/A'; ?></span>
				</div>
				
				<input type="submit" value="Change Settings" class="btn-normal">
				<div id="loader" style="text-align:center;"></div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<div class="modal fade" id="resetemail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Reset Notification Email</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div id="notify_msg"></div>
			</div>
			<?php echo $this->Form->create(false,['url' => 'javascript:void(0);', 'id' => 'notifyemail-settings-form', 'novalidate' => 'novalidate']); ?>
			<div class="modal-body">				
				<div class="form-group">
					<?php if($user_details['notification_email']=='')$em = $user_details['email'];else $em = $user_details['notification_email'];?>
					<?php echo $this->Form->input('notification_email', ['type'=>'email', 'placeholder'=>'Enter new email', 'label'=>false, 'class'=>'form-control', 'autocomplete'=>'off', 'value' =>$em, 'required'=>"required"]); ?>
				</div>				
			</div>
			<div id="notify_loader" style="text-align:center;"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-alt" data-dismiss="modal">Close</button>
				<input type="submit" class="btn btn-normal" value="Save changes">
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script>
//For account settings-form
$('#account-settings-form').validate({
	submitHandler:function(){
		var cat_id = $('#category_id').val();
		if ($("#posting_new_question_notification").is(":checked")){
			if(cat_id == null){
				var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Please select category.</div>";
				$('#cat_error').html(error_msg);
				setTimeout(function(){
					$('#cat_error').html('');
				},10000);
				return false;
			}else{
				$('#cat_error').html('');
				$('#loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
				var data = $('#account-settings-form').serialize();
				var promise = $.post('<?php echo Router::url("/users/account-setting/",true); ?>',data);
				promise.done(function(response){
					var data = JSON.parse(response);
					$('#loader').html('');
					if(data.submit=='success'){
						window.location.href = '<?php echo Router::url(array('controller'=>'Users','action'=>'account-setting'),true); ?>';
						setTimeout(function(){
							$('#pnq_error').html('');
					  },10000);
					}else{
						var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Nothing to update.</div>";
						$('#pnq_error').html(error_msg);
						setTimeout(function(){
							$('#pnq_error').html('');
						},10000);
					}
				});
				promise.fail(function(){
					var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Nothing to update.</div>";
					$('#pnq_error').html(error_msg);
					setTimeout(function(){
						$('#pnq_error').html('');
					},10000);
				});
			}
		}else{
			$('#pnq_error').html('');
			$('#loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
			var data = $('#account-settings-form').serialize();
			var promise = $.post('<?php echo Router::url("/users/account-setting/",true); ?>',data);
			promise.done(function(response){
				var data = JSON.parse(response);
				$('#loader').html('');
				if(data.submit=='success'){
					window.location.href = '<?php echo Router::url(array('controller'=>'Users','action'=>'account-setting'),true); ?>';
					setTimeout(function(){
						$('#pnq_error').html('');
				  },10000);
				}else if(data.submit=='nothing_to_update'){
					window.location.href = '<?php echo Router::url(array('controller'=>'Users','action'=>'account-setting'),true); ?>';
					setTimeout(function(){
						$('#pnq_error').html('');
					},10000);
				}else{
					var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Nothing to update.</div>";
					$('#pnq_error').html(error_msg);
					setTimeout(function(){
						$('#pnq_error').html('');
					},10000);
				}
			});
			promise.fail(function(){
				var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Nothing to update.</div>";
				$('#pnq_error').html(error_msg);
				setTimeout(function(){
					$('#pnq_error').html('');
				},10000);
			});
		}
	}
});

//For notify email settings-form
$('#notifyemail-settings-form').validate({
	submitHandler:function(){
		var notificationemail = $('#notification-email').val();
		$('#notify_loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var data = $('#notifyemail-settings-form').serialize();
		var promise = $.post('<?php echo Router::url("/users/notify-email-update/",true); ?>',data);
		promise.done(function(response){
			var data = JSON.parse(response);
			$('#notify_loader').html('');
			if(data.update=='success'){
				$('#noti_email').html(notificationemail);
				var success_msg = "<div class='message success' onclick='this.classList.add('hidden')'>Notify email is successfully updated.</div>";
				$('#notify_msg').html(success_msg);
				//$('#notifyemail-settings-form')[0].reset();
				setTimeout(function(){
					$('#notify_msg').html('');
			  },10000);
			}else{
				var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the admin.</div>";
				$('#notify_msg').html(error_msg);
				setTimeout(function(){
					$('#notify_msg').html('');
				},10000);
			}
		});
		promise.fail(function(){
			var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the developers.</div>";
			$('#notify_msg').html(msg);
			setTimeout(function(){
				$('#notify_msg').html('');
			},10000);
		});		
	}
});
</script>