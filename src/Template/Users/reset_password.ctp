<?php
use Cake\Routing\Router;
?>
<style>.error{color:#ff0000 !important;}</style>
<div class="genpage-user-system">
    <div class="container">
		<div class="reset-pass-box">
			<h1>Reset Your Password</h1>
			<p><small>All fields are mandatory</small></p>
			<div id="msg_div"><?php echo $this->Flash->render();?></div>
			<?php echo $this->Form->create($userdata,['role' => 'form', 'novalidate' => 'novalidate', 'id' => 'reset_password_form']); ?>
				<div class="form-group">
					<label for="">New Password</label>
					<?php echo $this->Form->input('password', ['type' => 'password', 'required' => true, 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'value' => '', 'error' => false]); ?>
				</div>
				<div class="form-group">
					<label for="">Confirm Password</label>
					<?php echo $this->Form->input('confirm_password', ['type' => 'password', 'required' => true, 'class' => 'form-control', 'label' => false, 'error' => false]); ?>
				</div>
				<div class="btn-set">
					<input type="submit" value="Submit" class="btn-normal">
				</div>      	   	
				<div class="resetnewpassword_loader" style="text-align:center;"></div>
			<?php echo $this->Form->end(); ?>
		</div>      
	</div>
</div>
<script type="text/javascript">
$('#reset_password_form').validate({
	rules: {
		password: 'required',
		confirm_password: {
			equalTo: '#password'
		}
	}
});
$(document).ready(function(){
	setTimeout(function(){
		$('#msg_div').html('');
	},10000);
});
</script>