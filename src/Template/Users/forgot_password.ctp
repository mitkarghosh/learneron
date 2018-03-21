<?php
use Cake\Routing\Router;
$session  = $this->request->session();
?>
<style>.error{color:#ff0000 !important;}</style>
<div class="genpage-user-system">
    <div class="container">
		<div class="reset-pass-box">
			<h1>Forgotten Password</h1>
			<p>Enter your email address associated with your account below to reset your password</p>
			<?php if($session->read('verify')=='invalid_url'){ ?>
				<div id="msg_div"><?php echo $this->Flash->render(); ?></div>
			<?php }else{ ?>
				<div id="msg_div"></div>
			<?php
			}
			$session->delete('verify');
			?>
			<?php echo $this->Form->create(false, array('url'=>'javascript:void(0)', 'class'=>'', 'novalidate' =>'novalidate','id'=>'forgot_password_form'));?>
				<div class="form-group">
					<label for="">Email Address</label>
					<?php echo $this->Form->input('email',['type'=>'email', 'placeholder'=>'Email Address', 'label'=>false, 'class'=>'form-control', 'required'=>"required"]); ?>
				</div>				
				<div class="btn-set">
					<input type="submit" value="Send Email" class="btn-normal">
				</div>      	   	
				<p class="text-center"><strong>Remember Password? <a href="<?php echo Router::url(array('controller'=>'Users','action'=>'login'),true);?>">Login</a></strong></p>
				<div class="forgotpassword_loader" style="text-align:center;"></div>
			<?php echo $this->Form->end(); ?>
		</div>      
	</div>
</div>
<script>
$('#forgot_password_form').validate({
	submitHandler:function(){
		$('.forgotpassword_loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var data = $('#forgot_password_form').serialize();
		var promise = $.post('<?php echo Router::url("/users/forgot-password/",true); ?>',data);		
		promise.done(function(response){
			var data = JSON.parse(response);
			$('.forgotpassword_loader').html('');
			if(data.status=='success'){
				var msg = "<div class='message success' onclick='this.classList.add('hidden')'>An email has been sent regarding password reset, please check your email.</div>";
				$('#forgot_password_form')[0].reset();
				$('#msg_div').html(msg);
				setTimeout(function(){
					$('#msg_div').html('');
				},10000);
			}else if(data.status=='not_active'){
				var msg = "<div class='message error'>This account is inactive.</div>";
				$('#msg_div').html(msg);
				setTimeout(function(){
					$('#msg_div').html('');
				},10000);
			}else if(data.status=='user_not_exist'){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>This email-id is not registered with us.</div>";
				$('#msg_div').html(msg);
				setTimeout(function(){
					$('#msg_div').html('');
				},10000);
			}else{
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the developers</div>";
				$('#msg_div').html(msg);
				setTimeout(function(){
					$('#msg_div').html('');
				},10000);
            }
        });
        promise.fail(function(){
			var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the developers.</div>";
            $('#msg_div').html(msg);
			setTimeout(function(){
				$('#msg_div').html('');
			},10000);
        });
    }
});
</script>