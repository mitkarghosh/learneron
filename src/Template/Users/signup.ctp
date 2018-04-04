<?php
use Cake\Routing\Router;
$session  = $this->request->session();
?>
<style>.error{color:#ff0000;}</style>
<div class="register-pages-wrapper">
	<div class="form-conatiner">
		<div class="form-conatiner-inner">
			<div class="form-left">
      	     	<h2>Signup With</h2>
      	     	<p>You also can sign up for LearnerOn.Net by using your existing social network account:</p>
      	     	<div class="btn-set">
      	     		<a href="javascript:void(0);" onclick="login_with_facebook();" class="fb-login">
      	     			<img src="<?php echo Router::url('/', true);?>images/login-fb.png" alt="">
      	     		</a>      	     		
      	     		<a href="javascript:void(0);" onclick="login_with_google();" class="gplus-login">      	     			
      	     			<img src="<?php echo Router::url('/', true);?>images/login-gplus.png" alt="">
      	     		</a>      	     		
      	     		<a hhref="javascript:void(0);" onclick="login_with_twitter();" class="tw-login">
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
					<?php if($session->read('from_verify')=='success'){ ?>
						<div id="msg_div"><?php echo $this->Flash->render(); ?></div>
					<?php }else{ ?>
						<div id="msg_div"></div>
					<?php } ?>
					
					<?php if($session->read('from_verify')=='invalid_url' || $session->read('from_verify')=='expired' || $session->read('email_check') == 'already_exist'){ ?>
						<div id="msg_div_error"><?php echo $this->Flash->render(); ?></div>
					<?php }else{ ?>
						<div id="msg_div_error"></div>
					<?php
						}
						$session->delete('from_verify');
					?>
					<?php echo $this->Form->create(false, array('url'=>'javascript:void(0)', 'class'=>'', 'novalidate' =>'novalidate','id'=>'signup_form'));?>
						<div class="form-group">
							<label for="">Your Name or Nick Name</label>
							<?php echo $this->Form->input('name',['type'=>'text', 'placeholder'=>'Your Name or NickName (Publicly Visible)', 'label'=>false, 'class'=>'form-control', 'required'=>"required"]); ?>
						</div>
						<div class="form-group" style="position:relative;">
							<label for="">Email</label> <span class="loader"></span>
							<?php echo $this->Form->input('email', ['type'=>'email', 'placeholder'=>'Email (Will be kept Private)', 'label'=>false, 'class'=>'form-control ckeck_duplicate', 'autocomplete'=>'off', 'required'=>"required"]); ?>
							<p class="exist_email"></p>
						</div>    	        	
						<div class="form-group">
							<label for="">Password</label>
							<?php echo $this->Form->input('password', ['type'=>'password', 'placeholder'=>'Password (Will be kept Private)', 'label'=>false, 'class'=>'form-control original_pass', 'required'=>"required"]); ?>
						</div>						
						<div class="form-group">
							<label for="">Confirm Password</label>
							<?php echo $this->Form->input('confirm_password', ['type'=>'password', 'placeholder'=>'Confirm Password', 'label'=>false, 'class'=>'form-control confirm_pass', 'required'=>"required"]); ?>
							<p class="confirm_pass_err"></p>
						</div>						
						<div class="check-box-set">
							<?php /*<input type="checkbox" id="is_setting" name="is_setting" value="1">
							<label for="is_setting">See Settings Now</label>
							<br>*/?>
							
							<input type="checkbox" id="agree" value="1">
							<label data-toggle="modal" data-target="#demo">I agree the Terms & Conditions</label>
							
							<input type="checkbox" id="personal_data" name="personal_data" value="1" checked>
							<label for="personal_data" title="">
								I agree with sending LearnerOn.net commercial communication and processing my personal data&nbsp;
								<img src="<?php echo Router::url('/images/info-icon.png');?>" data-toggle="tooltip_personaldata" data-original-title="I agree with sending commercial communications about LearnerOn.net service by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time." />
							</label>
							
							<input type="checkbox" id="is_commercialparty" name="is_commercialparty" value="1">
							<label for="is_commercialparty" title="">
								I agree with sending 3rd party commercial communication by Learneron, SE and processing my personal data&nbsp;
								<img src="<?php echo Router::url('/images/info-icon.png');?>" data-toggle="tooltip" data-original-title="I agree with sending third-party commercial communications by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time." />
							</label>
							
							<!--<input type="checkbox" id="personal_data" value="1">
							<label data-toggle="modal" data-target="#demo_personal_data" title="I agree with sending third-party commercial communications by electronic means and with the processing of my personal data, in particular the contact and identification data, by Learneron SE for this purpose. I may withdraw this consent at any time.">I agree with sending LearnerOn.net commercial communication and processing my personal data</label>-->
							
							<p id="agree_error"></p>
							<p id="personal_data_error"></p>
						</div>
						
						<div class="btn-set">
							<input type="submit" value="Sign Up">
						</div>
						<div class="signup_loader" style="text-align:center;"></div>
						<span class="sign-link">Already Have an Account? &nbsp; <a href="<?php echo Router::url('/login', true); ?>">Login</a></span>
					<?php echo $this->Form->end(); ?>
				</div>    	        
     	    </div>      	     
      	</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="demo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
				<button type="button" class="btn btn-normal" id="agree-btn" data-dismiss="modal">Agree</button>
			</div>			
		</div>
	</div>
</div>
<!--Persona data-->
<div class="modal fade bd-example-modal-lg" id="demo_personal_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
				<button type="button" class="btn btn-normal" id="personaldata-btn" data-dismiss="modal">Agree</button>
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
$('#agree-btn').click(function(){
	if(!$('#agree').is(":checked")){
		$('#agree').prop("checked",true);
    }else{
		$('#agree').prop("checked",false);
    }
});
/*$('#personaldata-btn').click(function(){
	if(!$('#personal_data').is(":checked")){
		$('#personal_data').prop("checked",true);
    }else{
		$('#personal_data').prop("checked",false);
    }
});*/
jQuery(function () {
	/* For sign up form */
	$('.ckeck_duplicate').focusout(function(e){
		var email = $(this).val();
		if(email.trim()!=''){
			$('.loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
			var promise = $.post('<?php echo Router::url("/users/email-exist/",true); ?>',JSON.stringify({email: email}));
			promise.done(function(response){
				$('.loader').html('');
				var data = JSON.parse(response);
				if(data.email=='exist'){
					//$('#email').val('');
					$('.exist_email').html('Email id already exist, try another.').css({'color':'red'});
					$('.ckeck_duplicate').css({'border':'1px solid red'});
				}else{
					$('.exist_email').html('');
					$('.ckeck_duplicate').css({'border':'1px solid #e7e7e7'});
				}
			});
			promise.fail(function(response){
				$('.exist_email').html('There was an unexpected error. Try again later or contact the developers.').css({'color':'red'});
			});
		} 
    });
	$('.confirm_pass').focusout(function(e){
        var password = $('.original_pass').val();
        confirm_password = $(this).val();            
        if(password != confirm_password){
			$('#confirm-password').val('');
			$(this).css({'border':'1px solid red'});
			$('.confirm_pass_err').html('Password does not match.').css({'color':'red'});
			return false;
        }else{
			$(this).css({'border':'1px solid #e7e7e7'});
			$('.confirm_pass_err').html('');
			return true;
        }
    });
  
    $('#signup_form').validate({
		submitHandler:function(){
			if (!$("#agree").is(":checked")) {
				var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Please select our terms and conditions.</div>";
				$('#agree_error').html(error_msg);
				setTimeout(function(){
					$('#agree_error').html('');
				},5000);
				return false;
			}
			/*else if (!$("#personal_data").is(":checked")) {
				var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Please select processing with my data.</div>";
				$('#personal_data_error').html(error_msg);
				setTimeout(function(){
					$('#personal_data_error').html('');
				},5000);
				return false;
			}*/
			else{
				$('#agree_error').html('');
				$('#personal_data').html('');
				$('.signup_loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
				var data = $('#signup_form').serialize();
				var promise = $.post('<?php echo Router::url("/users/signup/",true); ?>',data);
				promise.done(function(response){
					var data = JSON.parse(response);
					$('.signup_loader').html('');
					if(data.register=='success'){
						$('#user_id').val(data.userid);
						var success_msg = "<div class='message success' onclick='this.classList.add('hidden')'>Registration is successfull. An email has been sent, please verify your account.</div>";
						$('#msg_div').html(success_msg);
						$('#signup_form')[0].reset();
						setTimeout(function(){
							$('#msg_div').html('');
							$('#setting_data').modal('show');
					  },3000);
					}else{
						var error_msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the developers.</div>";
						$('#msg_div_error').html(error_msg);
						setTimeout(function(){
							$('#msg_div_error').html('');
						},5000);
					}
				});
				promise.fail(function(){
					var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the developers.</div>";
					$('#msg_div_error').html(msg);
					setTimeout(function(){
						$('#msg_div_error').html('');
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
	setTimeout(function(){
		$('#msg_div_error').html('');
	},5000);
});

/*Login with Facebook start here*/
function login_with_facebook(){
	FB.login(function(response){
		if (response.authResponse) {
			testAPI();
		}
	},{
		scope: 'public_profile,email'
	});
}
// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
	console.log('statusChangeCallback');
	console.log(response);
	// The response object is returned with a status field that lets the
	// app know the current login status of the person.
	// Full docs on the response object can be found in the documentation
	// for FB.getLoginStatus().
	if (response.status === 'connected') {
		// Logged into your app and Facebook.
		testAPI();
	} else if (response.status === 'not_authorized') {
		// The person is logged into Facebook, but not your app.
		/*document.getElementById('status').innerHTML = 'Please log ' + 'into this app.';*/
	} else {
		// The person is not logged into Facebook, so we're not sure if
		// they are logged into this app or not.
		/*document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook.';*/
	}
}
// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});
}
window.fbAsyncInit = function(){
	FB.init({
		appId      : '<?php echo FACEBOOK_APP_KEY;?>',
		cookie     : true,  // enable cookies to allow the server to access 
					// the session
		xfbml      : true,  // parse social plugins on this page
		version    : 'v2.6' // use graph api version 2.5
	});

	// Now that we've initialized the JavaScript SDK, we call 
	// FB.getLoginStatus().  This function gets the state of the
	// person visiting this page and can return one of three states to
	// the callback you provide.  They can be:
	//
	// 1. Logged into your app ('connected')
	// 2. Logged into Facebook, but not your app ('not_authorized')
	// 3. Not logged into Facebook and can't tell if they are logged into
	//    your app or not.
	//
	// These three cases are handled in the callback function.

	/*FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});*/
};
// Load the SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
	console.log('Welcome!  Fetching your information.... ');
	FB.api('/me', { fields: 'name, email, id' },function(response){
		var obj = JSON.stringify(response);
		//alert(response.email);
		if(typeof response.email==="undefined"){       
			var email ='noemail'+Math.random()+'@fb.com';
		}else{
			var email =response.email;
		}
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url : '<?php echo Router::url('/', true);?>users/facebook-login',
			data: JSON.stringify({'email': email,'name':response.name,'id':response.id}),
			success: function(response1){
				//console.clear();
				if(response1.type=='success'){
					$('#msg_div_error').html('');
					var login_msg = "<div class='message success' onclick='this.classList.add('hidden')'>Logged in successfully.</div>";
					$('#msg_div').html(login_msg);
					window.location.href = '<?php echo Router::url(array('controller'=>'Users','action'=>'my-account'),true); ?>';
				}else{
					var login_msg = "<div class='message error' onclick='this.classList.add('hidden')'>"+response1.msg+"</div>";
					$('#msg_div_error').html(login_msg);
					setTimeout(function(){
						$('#msg_div_error').html('');
					},5000);
				}
			},
			error: function(response1){
				var login_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Something went wrong, please try again later.</div>";
				$('#msg_div_error').html(login_msg);
				setTimeout(function(){
					$('#msg_div_error').html('');
				},5000);
			}
		});	
		//console.log('Successful login for: ' + response.email);
	});
}
/*Login with Facebook end here*/
</script>
<?php echo $this->element('social_login');?>