<?php
use Cake\Routing\Router;
?>
<!------------- For POST COMMENT-VOTE SECTION START ---------------->
<div class="modal fade login-modal-lg" id="comment_vote" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">   
		<div class="modal-content">
			<div class="modal-header text-right">
				<a href="javascript:void(0);">
      	     		<i class="fa fa-close" aria-hidden="true" data-dismiss="modal" onclick="javascript:close_popup_window();"></i>
      	     	</a>
			</div>
			<div class="form-conatiner login-form-commentvote">
				<div class="form-conatiner-inner">
					<div class="form-left">
						<h2>Login With</h2>
						<p>You also can login in LearnerOn.Net by using your existing social network account.</p>
						<div class="btn-set">
							<a href="javascript:void(0);" onclick="login_with_facebook_post_answer();" class="fb-login">
								<img src="<?php echo Router::url('/');?>images/login-fb.png" alt="">
							</a>      	     		
							<a href="javascript:void(0);" onclick="login_with_google();" class="gplus-login">      	     			
								<img src="<?php echo Router::url('/');?>images/login-gplus.png" alt="">
							</a>      	     		
							<a href="javascript:void(0);" onclick="login_with_twitter();" class="tw-login">
								<img src="<?php echo Router::url('/');?>images/login-tw.png" alt="">
							</a>      	     		
							<a href="javascript:void(0);" onclick="login_with_linkedin();" class="in-login">      	     			
								<img src="<?php echo Router::url('/');?>images/login-in.png" alt="">
							</a>
						</div>      	     	
					</div>      	     
					<div class="form-right">
						<h2>Login</h2>
						<div class="log-in-form-wrapper">	
							<?php echo $this->Form->create(false, array('url'=>'javascript:void(0)', 'novalidate' => 'novalidate', 'id'=>'ajax_login_form_comment_vote')); ?>
								<div id="login_msg_commentvote"></div>
								<div class="form-group">
									<label for="">Email</label>
									<?php echo $this->Form->input('email',['type'=>'email', 'placeholder'=>'nepdud@gmail.com', 'label'=>false, 'class'=>'form-control', 'required'=>"required"]); ?>
								</div>
								<div class="form-group">
									<label for="">Password</label>
									<?php echo $this->Form->input('password',['type'=>'password', 'placeholder'=>'*******', 'label'=>false, 'class'=>'form-control', 'required'=>"required"]); ?>
								</div>    	        	
								<div class="check-box-set">
									<input type="checkbox" name="remember_me" id="remember" value="1" />
									<label for="remember">Remember me</label>    	        		
									<a href="<?php echo Router::url('/forgot-password', true); ?>">forgot password</a>
								</div>
								<div id="ajax_login_loader_commentvote" style="text-align:center;"></div>
								<div class="btn-set">
									<input type="submit" value="Login">
								</div>    	        	
								<span class="sign-link">Not a Member? &nbsp; <a href="javascript:void(0);" class="openRegisterCommentvote">Sign Up </a></span>
							</form>    	     	
						</div>    	        
					</div>      	     
				</div>
			</div>
			<div class="form-conatiner register-from-commentvote" style="display: none;">
				<div class="form-conatiner-inner">
					<div class="form-left">
						<h2>Signup With</h2>
						<p>You also can sign up for LearnerOn.Net by using your existing social network account:</p>
						<div class="btn-set">
							<a href="javascript:void(0);" onclick="login_with_facebook_post_answer();" class="fb-login">
								<img src="<?php echo Router::url('/', true);?>images/login-fb.png" alt="">
							</a>      	     		
							<a href="javascript:void(0);" onclick="login_with_google();" class="gplus-login">      	     			
								<img src="<?php echo Router::url('/', true);?>images/login-gplus.png" alt="">
							</a>      	     		
							<a href="javascript:void(0);" onclick="login_with_twitter();" class="tw-login">
								<img src="<?php echo Router::url('/', true);?>images/login-tw.png" alt="">
							</a>      	     		
							<a href="javascript:void(0);" onclick="login_with_linkedin();" class="in-login">      	     			
								<img src="<?php echo Router::url('/', true);?>images/login-in.png" alt="">
							</a>      	     		
						</div>      	     	
					</div>
					<div class="form-right">
						<h2>Sign Up</h2>
						<div class="log-in-form-wrapper">
							<div id="msg_div_commentvote"></div>
							<?php echo $this->Form->create(false, array('url'=>'javascript:void(0)', 'class'=>'', 'novalidate' =>'novalidate','id'=>'signup_form_commentvote'));?>
								<div class="form-group">
									<label for="">Your Name or Nick Name</label>
									<?php echo $this->Form->input('name',['type'=>'text', 'placeholder'=>'Your Name or NickName (Publicly Visible)', 'label'=>false, 'class'=>'form-control', 'required'=>"required"]); ?>
								</div>
								<div class="form-group" style="position:relative;">
									<label for="">Email</label> <span class="loader_commentvote"></span>
									<?php echo $this->Form->input('email', ['type'=>'email', 'id'=>'email_address_commentvote', 'placeholder'=>'Email (Will be kept Private)', 'label'=>false, 'class'=>'form-control check_duplicate_email', 'autocomplete'=>'off', 'required'=>"required"]); ?>
									<p class="exist_email_commentvote"></p>
								</div>    	        	
								<div class="form-group">
									<label for="">Password</label>
									<?php echo $this->Form->input('password', ['type'=>'password', 'placeholder'=>'Password (Will be kept Private)', 'label'=>false, 'class'=>'form-control original_pass_commentvote', 'required'=>"required"]); ?>
								</div>						
								<div class="form-group">
									<label for="">Confirm Password</label>
									<?php echo $this->Form->input('confirm_password', ['type'=>'password', 'id'=>'confirm_pass_commentvote', 'placeholder'=>'Confirm Password', 'label'=>false, 'class'=>'form-control confirm_pass_commentvote', 'required'=>"required"]); ?>
									<p class="confirm_pass_err_commentvote"></p>
								</div>						
								<div class="check-box-set">
									<?php /*<input type="checkbox" id="is_setting_commentvote" name="is_setting" value="1">
									<label for="is_setting">See Settings Now</label>
									<br>*/?>
									<input type="checkbox" id="agree_commentvote" value="1">
									<label data-toggle="modal" data-target="#democommentvote">I agree the Terms & Conditions</label>
									
									<input type="checkbox" id="personal_data_commentvote" name="personal_data_commentvote" value="1" checked>
									<label for="personal_data_commentvote" title="">
										I agree with sending LearnerOn.net commercial communication and processing my personal data&nbsp;
										<img src="<?php echo Router::url('/images/info-icon.png');?>" data-toggle="tooltip_personaldata" data-original-title="I agree with sending commercial communications about LearnerOn.net service by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time." />
									</label>
									
									<input type="checkbox" id="is_commercialparty" name="is_commercialparty" value="1">
									<label for="is_commercialparty" title="">
										I agree with sending 3rd party commercial communication by Learneron, SE and processing my personal data&nbsp;
										<img src="<?php echo Router::url('/images/info-icon.png');?>" data-toggle="tooltip" data-original-title="I agree with sending third-party commercial communications by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time." />
									</label>
									
									<!--<input type="checkbox" id="personal_data_commentvote" value="1">
									<label data-toggle="modal" data-target="#demo_personal_data_commentvote" title="I agree with sending third-party commercial communications by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time.">I agree with sending LearnerOn.net commercial communication and processing my personal data</label>-->
									
									<p id="agree_error_commentvote"></p>
								</div>    	        	
								<div class="btn-set">
									<input type="submit" value="Sign Up">
								</div>
								<div class="signup_loader_commentvote" style="text-align:center;"></div>
								<span class="sign-link">Already Have an Account? &nbsp; <a href="javascript:void(0);" class="openLoginCommentvote">Login</a></span>
							<?php echo $this->Form->end(); ?>
						</div>
					</div>      	     
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg" id="democommentvote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Terms &amp; Conditions</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo $terms_and_conditions['description'];?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-alt" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-normal" id="agree-btn-commentvote" data-dismiss="modal">Agree</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="comment-from-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Share a comment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php
			echo $this->Form->create(false, array('url'=>'javascript:void(0)', 'novalidate' => 'novalidate', 'id'=>'question_comment_form'));
				echo $this->Form->input('question_id',['type'=>'hidden', 'label'=>false, 'class'=>'form-control','value'=>base64_encode($detail->id)]);
			?>
			<div class="modal-body">				
				<div class="form-group">
					<?php echo $this->Form->input('question_comment',['type'=>'textarea', 'placeholder'=>'Post your comment', 'label'=>false, 'class'=>'form-control', 'required'=>true]);?>
				</div>
				<div id="question_comment_msg"></div>
			</div>
			<div id="question_comment_loader" style="text-align:center"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-alt" data-dismiss="modal">Close</button>
				<input type="submit" class="btn btn-normal" value="Submit">
			</div>
			<?php echo $this->Form->end();?>
		</div>
	</div>
</div>

<!--Persona data-->
<div class="modal fade bd-example-modal-lg" id="demo_personal_data_commentvote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Your personal data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo $personal_data['description'];?>     
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-alt" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-normal" id="personaldata-btn-commentvote" data-dismiss="modal">Agree</button>
			</div>
		</div>
	</div>
</div>

<!-- Setting Popup -->
<div class="modal fade bd-example-modal-lg" id="setting_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
					<div class="modal-footer">
						<button type="button" class="btn btn-alt" data-dismiss="modal">No</button>
						<button type="submit" class="btn btn-normal">Yes</button>
					</div>
					<div class="setting_loader" style="text-align:center;"></div>
				<?php echo $this->Form->end(); ?>
			</div>			
		</div>
	</div>
</div>
<!-- Setting Popup -->

<script>
$('#agree-btn-commentvote').click(function(){
	if(!$('#agree_commentvote').is(":checked")){
		$('#agree_commentvote').prop("checked",true);
    }else{
		//$('#agree').prop("checked",false);
    }
});

/*$('#personaldata-btn-commentvote').click(function(){
	if(!$('#personal_data_commentvote').is(":checked")){
		$('#personal_data_commentvote').prop("checked",true);
    }else{
		$('#personal_data_commentvote').prop("checked",false);
    }
});*/

$('#ajax_login_form_comment_vote').validate({
	submitHandler:function(){
		$('#ajax_login_loader_commentvote').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var data = $('#ajax_login_form_comment_vote').serialize();
		var promise = $.post('<?php echo Router::url("/users/ajax-login/",true); ?>',data);
		promise.done(function(response){
			$('#ajax_login_loader_commentvote').html('');
			var data = JSON.parse(response);
			if(data.login=='success'){
				$('#login_msg_commentvote').html('');
				var login_msg_commentvote = "<div class='message success' onclick='this.classList.add('hidden')'>Logged in successfully. You will be redirect soon.</div>";
				$('#login_msg_commentvote').html(login_msg_commentvote);
				setTimeout(function(){
					$('#login_msg_commentvote').html('');
					$('#login-modal').modal('hide');
					window.location.reload();
				},3000);				
			}else if(data.login=='success_to_setting'){
				$('#login_msg_commentvote').html('');
				var login_msg_commentvote = "<div class='message success' onclick='this.classList.add('hidden')'>Logged in successfully.</div>";
				$('#login_msg_commentvote').html(login_msg_commentvote);
				$('#login-modal').modal('hide');
				window.location.href = '<?php echo Router::url(array('controller'=>'Users','action'=>'account-setting'),true); ?>';
			}else if(data.login=='user_not_exist'){
				var login_msg_commentvote = "<div class='message error' onclick='this.classList.add('hidden')'>This email-id is not registered with us.</div>";
				$('#login_msg_commentvote').html(login_msg_commentvote);
				setTimeout(function(){
					$('#login_msg_commentvote').html('');
				},3000);
			}else if(data.login=='user_not_activated'){
				var login_msg_commentvote = "<div class='message error' onclick='this.classList.add('hidden')'>Account not activated yet, check your email to activate your account or please contact with Admin.</div>";
				$('#login_msg_commentvote').html(login_msg_commentvote);
				setTimeout(function(){
					$('#login_msg_commentvote').html('');
				},5000);
			}else if(data.login=='not_logged_in'){
				var login_msg_commentvote = "<div class='message error' onclick='this.classList.add('hidden')'>Invalid Email or Password.</div>";
				$('#login_msg_commentvote').html(login_msg_commentvote);
				setTimeout(function(){
					$('#login_msg_commentvote').html('');
				},5000);
			}else if(data.login=='already_logged_in'){
				var login_msg_commentvote = "<div class='message error' onclick='this.classList.add('hidden')'>Already logged in.</div>";
				$('#login_msg_commentvote').html(login_msg_commentvote);
				setTimeout(function(){
					$('#login_msg_commentvote').html('');
				},5000);
				$('#login-modal').modal('hide');
			}else{
				var login_msg_commentvote = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
				$('#login_msg_commentvote').html(login_msg_commentvote);
				setTimeout(function(){
					$('#login_msg_commentvote').html('');
				},5000);
			}
		});
		promise.fail(function(){
			$('#ajax_login_loader_commentvote').html('');
			var login_msg_commentvote = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
			$('#login_msg_commentvote').html(login_msg_commentvote);
			setTimeout(function(){
				$('#login_msg_commentvote').html('');
			},5000);
		});
	}
});

/* For sign up form */
$('.check_duplicate_email').focusout(function(e){
	var email = $(this).val();
	if(email.trim()!=''){
		$('.loader_commentvote').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var promise = $.post('<?php echo Router::url("/users/email-exist/",true); ?>',JSON.stringify({email: email}));
		promise.done(function(response){
			$('.loader_commentvote').html('');
			var data = JSON.parse(response);
			if(data.email=='exist'){
				$('#email_address_commentvote').val('');
				$('.exist_email_commentvote').html('Email id already exist, try another.').css({'color':'red'});
				$('.check_duplicate_email').css({'border':'1px solid red'});
			}else{
				$('.exist_email_commentvote').html('');
				$('.check_duplicate_email').css({'border':'1px solid #e7e7e7'});
			}
		});
		promise.fail(function(response){
			$('.exist_email_commentvote').html('There was an unexpected error. Try again later or contact the developers.').css({'color':'red'});
		});
	} 
});
$('.confirm_pass_commentvote').focusout(function(e){
	var password = $('.original_pass_commentvote').val();
	confirm_password = $(this).val();            
	if(password != confirm_password){
		$('#confirm_pass_commentvote').val('');
		$(this).css({'border':'1px solid red'});
		$('.confirm_pass_err_commentvote').html('Password does not match.').css({'color':'red'});
		return false;
	}else{
		$(this).css({'border':'1px solid #e7e7e7'});
		$('.confirm_pass_err_commentvote').html('');
		return true;
	}
});
$('#signup_form_commentvote').validate({
	submitHandler:function(){
		if (!$("#agree_commentvote").is(":checked")) {
			var error_msg_commentvote = "<div class='message error' onclick='this.classList.add('hidden')'>Please select our terms and conditions.</div>";
			$('#agree_error_commentvote').html(error_msg);
			setTimeout(function(){
				$('#agree_error_commentvote').html('');
			},5000);
			return false;
		}else{
			$('#agree_error_commentvote').html('');
			$('.signup_loader_commentvote').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
			var data = $('#signup_form_commentvote').serialize();
			var promise = $.post('<?php echo Router::url("/users/signup/",true); ?>',data);
			promise.done(function(response){
				var data = JSON.parse(response);
				$('.signup_loader_commentvote').html('');
				if(data.register=='success'){
					$('#user_id').val(data.userid);
					var success_msg = "<div class='message success' onclick='this.classList.add('hidden')'>Registration is successfull. An email has been sent, please verify your account.</div>";
					$('#msg_div_commentvote').html(success_msg);
					$('#signup_form_commentvote')[0].reset();
					setTimeout(function(){
						$('#msg_div_commentvote').html('');
						$('#comment_vote').modal('hide');
						$('#setting_data').modal('show');
				  },3000);
				}else{
					var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
					$('#msg_div_commentvote').html(error_msg);
					setTimeout(function(){
						$('#msg_div_commentvote').html('');
					},5000);
				}
			});
			promise.fail(function(){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
				$('#msg_div_commentvote').html(msg);
				setTimeout(function(){
					$('#msg_div_commentvote').html('');
				},5000);
			});
		}
	}
});
$('#setting_form').validate({
	submitHandler:function(){
		if (!$("#is_setting").is(":checked")) {
			var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Please select to see setting page after first time login.</div>";
			$('#setting_check_error').html(error_msg);
			setTimeout(function(){
				$('#setting_check_error').html('');
			},5000);
			return false;
		}
		else{
			$('#setting_check_error').html('');
			$('.setting_loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
			var data = $('#setting_form').serialize();
			var promise = $.post('<?php echo Router::url("/users/signup_setting/",true); ?>',data);
			promise.done(function(response){
				var data = JSON.parse(response);
				$('.setting_loader').html('');
				if(data.register=='success'){
					var success_msg = "<div class='message success' onclick='this.classList.add('hidden')'>Thank you.</div>";
					$('#setting_check_error').html(success_msg);
					$('#setting_form')[0].reset();
					setTimeout(function(){
						$('#setting_check_error').html('');
						$('#setting_data').modal('hide');
					},3000);
				}else{
					var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the developers.</div>";
					$('#setting_check_error').html(error_msg);
					setTimeout(function(){
						$('#setting_check_error').html('');
					},5000);
				}
			});
			promise.fail(function(){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the developers.</div>";
				$('#setting_check_error').html(msg);
				setTimeout(function(){
					$('#setting_check_error').html('');
				},5000);
			});
		}
	}
});

function close_popup_window(){
	$('#msg_div_commentvote').html('');
	$('#login_msg_commentvote').html('');
	$('#comment_vote').modal('hide');
}

//Question comment form start here
$('#question_comment_form').validate({
	submitHandler:function(){
		$('#question_comment_loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var data = $('#question_comment_form').serialize();
		var promise = $.post('<?php echo Router::url("/questions/post-question-comment/",true); ?>',data);
		promise.done(function(response){
			var data = JSON.parse(response);
			$('#question_comment_loader').html('');
			if(data.submission=='user_not_logged_in'){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Login required to post question comment.</div>";
				$('#question_comment_msg').html(msg);
				$('#question_comment_form')[0].reset();
				setTimeout(function(){
					$('#question_comment_msg').html('');
					$('#comment-from-popup').modal('hide');
					$('#comment_vote').modal('show');
				},5000);
			}else if(data.submission=='already_posted'){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Your comment for this question is already posted.</div>";
				$('#question_comment_msg').html(msg);
				$('#question_comment_form')[0].reset();
				setTimeout(function(){
					$('#question_comment_msg').html('');
					//$('#comment-from-popup').modal('hide');
				},5000);
			}else if(data.submission=='success'){
				var msg = "<div class='message success' onclick='this.classList.add('hidden')'>Comment has been successfully submitted.</div>";
				$('#question_comment_msg').html(msg);
				$('#question_comment_form')[0].reset();
				setTimeout(function(){
					$('#question_comment_msg').html('');
					$('#comment-from-popup').modal('hide');
					window.location.reload();
				},3000);
			}else if(data.submission=='success_approval'){
				var msg = "<div class='message success' onclick='this.classList.add('hidden')'>Comment has been successfully submitted. It needs Admin approval.</div>";
				$('#question_comment_msg').html(msg);
				$('#question_comment_form')[0].reset();
				setTimeout(function(){
					$('#question_comment_msg').html('');
					$('#comment-from-popup').modal('hide');
				},5000);
			}else if(data.submission=='same_user'){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Your cannot post comment to your own question.</div>";
				$('#question_comment_msg').html(msg);
				$('#question_comment_form')[0].reset();
				setTimeout(function(){
					$('#question_comment_msg').html('');
					$('#comment-from-popup').modal('hide');
				},5000);
			}else{
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
				$('#question_comment_msg').html(msg);
				setTimeout(function(){
					$('#question_comment_msg').html('');
				},5000);
			}
		});
		promise.fail(function(){
			var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
			$('#question_comment_msg').html(msg);
			setTimeout(function(){
				$('#question_comment_msg').html('');
			},5000);
		});		
	}
});
//Question comment form end here
</script>
<!------------- For POST COMMENT-VOTE SECTION END ---------------->
