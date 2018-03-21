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
		<?php echo $this->Form->create($password,['id' => 'change_password_form', 'novalidate' => 'novalidate', 'novalidate' => 'novalidate']); ?>
			<div class="form-group">
					<label for="">New Password</label>
					<?php echo $this->Form->input('new_password', ['type' => 'password', 'required' => true, 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'value' => '', 'placeholder'=>'*******']); ?>
				</div>
				<div class="form-group">
					<label for="">Confirm Password</label>
					<?php echo $this->Form->input('confirm_password', ['type' => 'password', 'required' => true, 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'value' => '', 'placeholder'=>'*******']); ?>
				</div>

			<div class="form-group row">
				<div class="col-sm-10">
					<?php echo $this->Form->button('Update',['class' => 'btn btn-success', 'type' => 'submit' ]);?>&nbsp;
				<a href="<?php echo Router::url('/admin/admin-details/list-sub-admin',true); ?>" class="btn btn-primary">Cancel</a>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</article>
<script>
$('#change_password_form').validate({
	rules: {
		new_password: 'required',
		confirm_password: {
			equalTo: '#confirm_password'
		}
	}
});
$(document).ready(function(){
	setTimeout(function(){
		$('#message').html('');
	},5000);
});
</script>