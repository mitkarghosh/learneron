<?php
use Cake\Routing\Router;
$session = $this->request->session();
?>
<div class="register-pages-wrapper">
    <div class="form-conatiner">
		<div class="form-conatiner-inner">
			<div class="form-left">
				<h2>Login With</h2>
      	     	<p>You also can login in LearnerOn.Net by using your existing social network account.</p>      	     	
      	     	<div class="btn-set">
      	     		<a href="javascript:void(0);" onclick="login_with_facebook();" class="fb-login">
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
			 	<h2>Login</h2>
				<div class="log-in-form-wrapper">
					<div id="msg_div">
					<?php
					if($session->read('from_verify') == 'success'){
						echo $this->Flash->render();
					}
					if($session->read('reset_password')=='success'){
						echo $this->Flash->render();
						$session->delete('reset_password');
					}
					?>
					</div>
					<div id="msg_div_error">
					<?php
					if($session->read('from_verify') == 'invalid_url'){
						echo $this->Flash->render();
					}
					$session->delete('from_verify');
					if($session->read('email_check') == 'already_exist'){
						echo $this->Flash->render();
					}
					$session->delete('email_check');
					?>
					</div>
				<?php
				echo $this->Form->create(false, array('url'=>'javascript:void(0)', 'class'=>'login_form', 'novalidate' => 'novalidate', 'id'=>'login_form')); ?>
    	        	<div class="form-group">
    	        	    <label for="">Email</label>
    	        		<?php echo $this->Form->input('email',['type'=>'email', 'placeholder'=>'nepdud@gmail.com', 'label'=>false, 'class'=>'form-control', 'required'=>"required"]); ?>
    	        	</div>
    	        	<div class="form-group">
    	        	    <label for="">Password</label>
    	        		<?php echo $this->Form->input('password',['type'=>'Password', 'placeholder'=>'*******', 'label'=>false, 'class'=>'form-control', 'required'=>"required"]); ?>
    	        	</div>    	        	
    	        	<div class="check-box-set">
    	        		<input type="checkbox" name="remember_me" id="remember" value="1" />
    	        		<label for="remember">Remember me</label>    	        		
    	        		<a href="<?php echo Router::url('/forgot-password', true); ?>">forgot password</a>
    	        	</div>    	        	
    	        	<div class="btn-set">
    	        		<input type="submit" value="Login">
    	        	</div>
    	        	<div class="login_loader" style="text-align:center;"></div>
    	        	<span class="sign-link">Not a Member? &nbsp; <a href="<?php echo Router::url('/signup', true); ?>">Sign Up </a></span>
    	        <?php echo $this->Form->end(); ?>    	     	
				</div>    	      
			</div>      	     
      	</div>
	</div>
</div>
<script>
$('#login_form').validate({
	submitHandler:function(){
		$('.login_loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var data = $('#login_form').serialize();
		var promise = $.post('<?php echo Router::url("/users/login/",true); ?>',data);
		promise.done(function(response){
			$('.login_loader').html('');
			var data = JSON.parse(response);
			if(data.login=='success'){
				$('#msg_div_error').html('');
				var login_msg = "<div class='message success' onclick='this.classList.add('hidden')'>Logged in successfully.</div>";
				$('#msg_div').html(login_msg);
				window.location.href = '<?php echo Router::url(array('controller'=>'Users','action'=>'my-account'),true); ?>';
			}else if(data.login=='success_to_setting'){
				$('#msg_div_error').html('');
				var login_msg = "<div class='message success' onclick='this.classList.add('hidden')'>Logged in successfully</div>";
				$('#msg_div').html(login_msg);
				window.location.href = '<?php echo Router::url(array('controller'=>'Users','action'=>'account-setting'),true); ?>';
			}else if(data.login=='user_not_exist'){
				var login_msg = "<div class='message error' onclick='this.classList.add('hidden')'>This email-id is not registered with us.</div>";
				$('#msg_div_error').html(login_msg);
				setTimeout(function(){
					$('#msg_div_error').html('');
				},5000);
			}else if(data.login=='user_not_activated'){
				var login_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Account not activated yet, check your email to activate your account or please contact with Admin.</div>";
				$('#msg_div_error').html(login_msg);
				setTimeout(function(){
					$('#msg_div_error').html('');
				},5000);
			}else if(data.login=='not_logged_in'){
				var login_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Invalid Email or Password.</div>";
				$('#msg_div_error').html(login_msg);
				setTimeout(function(){
					$('#msg_div_error').html('');
				},5000);
			}else{
				var login_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Invalid Email or Password.</div>";
				$('#msg_div_error').html(login_msg);
				setTimeout(function(){
					$('#msg_div_error').html('');
				},5000);
			}
		});
		promise.fail(function(){
			$('.login_loader').html('');
			var login_msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
			$('#msg_div_error').html(login_msg);
			setTimeout(function(){
				$('#msg_div_error').html('');
			},5000);
		});
	}
});
$(document).ready(function(){
	setTimeout(function(){
		$('#msg_div').html('');
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