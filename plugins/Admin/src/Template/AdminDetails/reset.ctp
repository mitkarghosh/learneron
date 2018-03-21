<div class="auth-content">
    <p class="text-xs-center">PASSWORD RECOVER</p>
    <?php echo $this->Flash->render() ?>
    <p class="text-muted text-xs-center"><small>Enter your email address to recover your password.</small></p>
    <?php echo $this->Form->create(null,['id' => 'reset-form', 'novalidate' => 'novalidate']); ?>

        <div class="form-group">
            <?php echo $this->Form->input('email', ['required' => true, 'class' => 'form-control underlined', 'placeholder' => 'Your email address']); ?>
        </div>

        <div class="form-group">
        	<button type="submit" class="btn btn-block btn-primary">Reset</button>
        </div>
        <div class="form-group clearfix">
        	<?php echo $this->Html->link('Return to Login',['controller' => 'AdminDetails', 'action' => 'login', '_full' => true],['class' => 'pull-left']); ?>
        </div>
    <?php echo $this->Form->end(); ?>
</div>