<div class="auth-content">
    <p class="text-xs-center">Reset Your Password</p>
    <?php echo $this->Flash->render() ?>
    <p class="text-muted text-xs-center"><small>All fields are required</small></p>
    <?php echo $this->Flash->render(); ?>
	<?php echo $this->Form->create(null,['role' => 'form', 'novalidate' => 'novalidate', 'id' => 'reset_pass_form']); ?>

        <div class="form-group">
			<div class="form-group">
				<?php echo $this->Form->input('password', ['type' => 'password', 'required' => true, 'class' => 'form-control underlined', 'label' => ['text' => 'New Password','class' => 'control-label'], 'error' => false]); ?>
			</div>

			<div class="form-group">
				<?php echo $this->Form->input('confirm_password', ['type' => 'password', 'required' => true, 'class' => 'form-control underlined', 'label' => ['text' => 'Confirm Password','class' => 'control-label'], 'error' => false]); ?>
			</div>

			<div class="form-group">
				<?php echo $this->Form->button('Update',['class' => 'btn btn-success', 'type' => 'submit' ]); ?>
			</div>
		</div>
    <?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
  $('#reset_pass_form').validate({
      rules: {
        password: 'required',
        confirm_password: {
            equalTo: '#password'
        }
    }
  });
</script>