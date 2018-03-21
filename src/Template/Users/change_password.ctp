<?php use Cake\Routing\Router; ?>
<div class="genpage-user-system">
    <div class="container">
		<div class="reset-pass-box">
			<h1>Change Password</h1>
			<div id="message"><?php echo $this->Flash->render();?></div>
			<?php echo $this->Form->create($userdetails,['role'=>'Form', 'novalidate'=>'novalidate', 'class'=>'change_password_form', 'id'=>'change_password_form']);?>
				<div class="form-group">
					<label for="">Old Password</label>
					<?php echo $this->Form->input('old_password', ['type' => 'password', 'required' => true, 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'value' => '', 'placeholder'=>'*******']); ?>
				</div>
				<div class="form-group">
					<label for="">New Password</label>
					<?php echo $this->Form->input('new_password', ['type' => 'password', 'required' => true, 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'value' => '', 'placeholder'=>'*******']); ?>
				</div>
				<div class="form-group">
					<label for="">Confirm Password</label>
					<?php echo $this->Form->input('confirm_password', ['type' => 'password', 'required' => true, 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'value' => '', 'placeholder'=>'*******']); ?>
				</div>
				<div class="btn-set">
					<input type="submit" value="Change Password" class="btn-normal">
				</div>      	   	
			<?php echo $this->Form->end();?>			
      </div>
      
    </div>
  </div>
<script>
$('#change_password_form').validate({
	rules: {
		new_password: 'required',
		confirm_password: {
			equalTo: '#new-password'
		}
	}
});
$(document).ready(function(){
	setTimeout(function(){
		$('#message').html('');
	},5000);
});
</script>