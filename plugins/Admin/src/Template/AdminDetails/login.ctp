<div class="auth-content">
    <p class="text-xs-center">LOGIN TO CONTINUE</p>
    <?php echo $this->Flash->render() ?>
    <?php echo $this->Form->create(null,['id' => 'login-form', 'novalidate' => 'novalidate']); ?>
        <div class="form-group">
			<div class="form-group">
				<?php echo $this->Form->input('email', ['required' => true, 'class' => 'form-control underlined', 'placeholder' => 'Your email address']); ?>
			</div>

			<div class="form-group">
				<?php echo $this->Form->input('password', ['required' => true, 'class' => 'form-control underlined', 'placeholder' => 'Your password']); ?>
			</div>

			<div class="form-group">
				<?php echo $this->Form->button('Login',['class' => 'btn btn-block btn-primary']); ?>
				<?php echo $this->Html->link('Forgot password?',['controller' => 'AdminDetails', 'action' => 'reset', '_full' => true],['class' => 'forgot-btn pull-right']); ?>
			</div>
		</div>
    <?php echo $this->Form->end(); ?>