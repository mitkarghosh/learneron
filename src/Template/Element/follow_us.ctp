<?php use Cake\Routing\Router; ?>
<h3>For More Information </h3>
<?php if(empty($Auth)){ ?>
	<a href="javascript:void(0);" class="news-letter-btn" data-toggle="modal" data-target="#subscribe"><i class="fa fa-bullhorn"></i>Subscribe For News & Views</a>
	<a href="https://twitter.com/LearneronSE" target="_blank" class="twitter-btn"><i class="fa fa-twitter"></i>Follow Us On Twitter</a>
<?php }else{ ?>
	<a href="<?php echo Router::url('/account-setting',true);?>" class="news-letter-btn"><i class="fa fa-bullhorn"></i>Subscribe For News & Views</a>
	<a href="https://twitter.com/LearneronSE" target="_blank" class="twitter-btn"><i class="fa fa-twitter"></i>Follow Us On Twitter</a>
<?php } ?>

<!------------- For Subscribe For News & Views SECTION START ---------------->
<div class="modal fade login-modal-lg" id="subscribe" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
							<a href="javascript:void(0);" onclick="login_with_facebook();" class="fb-login">
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
							<?php echo $this->Form->create(false, array('url'=>'javascript:void(0)', 'novalidate' => 'novalidate', 'id'=>'ajax_login_form_subscribe'));	?>
								<div id="login_msg_subscribe"></div>
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
								<div id="ajax_login_loader_subscribe" style="text-align:center;"></div>
								<div class="btn-set">
									<input type="submit" value="Login">
								</div>								
							</form>    	     	
						</div>    	        
					</div>      	     
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$('#ajax_login_form_subscribe').validate({
	submitHandler:function(){
		$('#ajax_login_loader_subscribe').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var data = $('#ajax_login_form_subscribe').serialize();
		var promise = $.post('<?php echo Router::url("/users/ajax-login/",true); ?>',data);
		promise.done(function(response){
			$('#ajax_login_loader_subscribe').html('');
			var data = JSON.parse(response);
			if(data.login=='success'){
				$('#login_msg_subscribe').html('');
				var login_msg_commentvote = "<div class='message success' onclick='this.classList.add('hidden')'>Logged in successfully. You will be redirect soon.</div>";
				$('#login_msg_subscribe').html(login_msg_commentvote);
				setTimeout(function(){
					$('#login_msg_subscribe').html('');
					$('#login-modal').modal('hide');
					window.location.href = '<?php echo Router::url(array('controller'=>'Users','action'=>'account-setting'),true); ?>';
				},3000);				
			}else if(data.login=='success_to_setting'){
				$('#login_msg_subscribe').html('');
				var login_msg_subscribe = "<div class='message success' onclick='this.classList.add('hidden')'>Logged in successfully.</div>";
				$('#login_msg_subscribe').html(login_msg_subscribe);
				$('#login-modal').modal('hide');
				window.location.href = '<?php echo Router::url(array('controller'=>'Users','action'=>'account-setting'),true); ?>';
			}else if(data.login=='user_not_exist'){
				var login_msg_subscribe = "<div class='message error' onclick='this.classList.add('hidden')'>This email-id is not registered with us.</div>";
				$('#login_msg_subscribe').html(login_msg_subscribe);
				setTimeout(function(){
					$('#login_msg_subscribe').html('');
				},3000);
			}else if(data.login=='user_not_activated'){
				var login_msg_subscribe = "<div class='message error' onclick='this.classList.add('hidden')'>Account not activated yet, check your email to activate your account or please contact with Admin.</div>";
				$('#login_msg_subscribe').html(login_msg_subscribe);
				setTimeout(function(){
					$('#login_msg_subscribe').html('');
				},5000);
			}else if(data.login=='not_logged_in'){
				var login_msg_subscribe = "<div class='message error' onclick='this.classList.add('hidden')'>Invalid Email or Password.</div>";
				$('#login_msg_subscribe').html(login_msg_subscribe);
				setTimeout(function(){
					$('#login_msg_subscribe').html('');
				},5000);
			}else if(data.login=='already_logged_in'){
				var login_msg_subscribe = "<div class='message error' onclick='this.classList.add('hidden')'>Already logged in.</div>";
				$('#login_msg_subscribe').html(login_msg_subscribe);
				setTimeout(function(){
					$('#login_msg_subscribe').html('');
				},5000);
				$('#login-modal').modal('hide');
			}else{
				var login_msg_subscribe = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
				$('#login_msg_subscribe').html(login_msg_subscribe);
				setTimeout(function(){
					$('#login_msg_subscribe').html('');
				},5000);
			}
		});
		promise.fail(function(){
			$('#ajax_login_loader_subscribe').html('');
			var login_msg_subscribe = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
			$('#login_msg_subscribe').html(login_msg_subscribe);
			setTimeout(function(){
				$('#login_msg_subscribe').html('');
			},5000);
		});
	}
});

function close_popup_window(){
	$('#login_msg_subscribe').html('');
	$('#subscribe').modal('hide');
}

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
					$('#login_msg_subscribe').html('');
					var login_msg = "<div class='message success' onclick='this.classList.add('hidden')'>Logged in successfully.</div>";
					$('#login_msg_subscribe').html(login_msg);
					window.location.href = '<?php echo Router::url('/account-setting',true); ?>';
				}else{
					var login_msg = "<div class='message error' onclick='this.classList.add('hidden')'>"+response1.msg+"</div>";
					$('#login_msg_subscribe').html(login_msg);
					setTimeout(function(){
						$('#login_msg_subscribe').html('');
					},5000);
				}
			},
			error: function(response1){
				var login_msg = "<div class='message error' onclick='this.classList.add('hidden')'>Something went wrong, please try again later.</div>";
				$('#login_msg_subscribe').html(login_msg);
				setTimeout(function(){
					$('#login_msg_subscribe').html('');
				},5000);
			}
		});	
		//console.log('Successful login for: ' + response.email);
	});
}
/*Login with Facebook end here*/
</script>