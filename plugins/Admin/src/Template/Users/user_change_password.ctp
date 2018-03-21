<?php use Cake\Routing\Router;?>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Change Passsword
         <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <div class="card card-block sameheight-item">
		<?php echo $this->Flash->render(); ?>
		<?php echo $this->Form->create($password,['id' => 'login-form', 'novalidate' => 'novalidate', 'novalidate' => 'novalidate']); ?>
			<div class="form-group <?php if($this->Form->isFieldError('new_password')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
				<?php echo $this->Form->input('new_password', ['type' => 'password', 'required' => true, 'class' => 'form-control underlined', 'label' => ['text' => 'New Passsword','class' => 'control-label'], 'error' => false, 'autocomplete' => false]);
					echo $this->Form->error('new_password', null); ?>
			</div>

			<div class="form-group <?php if($this->Form->isFieldError('confirm_password')): echo 'has-error'; else: echo 'has-success'; endif; ?>">
				<?php echo $this->Form->input('confirm_password', ['type' => 'password', 'required' => true, 'class' => 'form-control underlined', 'label' => ['text' => 'Confirm Passsword','class' => 'control-label'], 'error' => false]);
					echo $this->Form->error('confirm_password', null); ?>
			</div>

			<div class="form-group row">
				<div class="col-sm-10">
					<?php echo $this->Form->button('Update',['class' => 'btn btn-success', 'type' => 'submit' ]);?>&nbsp;
				<a href="<?php echo Router::url('/admin/users/list-data',true); ?>" class="btn btn-primary">Cancel</a>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</article>