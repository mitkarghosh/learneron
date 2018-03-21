<?php
use Cake\Routing\Router;
$session  = $this->request->session();
?>
<div class="genpage-user-system">
    <div class="container">
		<div class="title">
			<h1>Edit Question Comment</h1>
		</div>
		<div class="genpage-wrapper">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="user-profile-details">
						<div id="edit_profile_msg"><?php echo $this->Flash->render();?></div>
						<div class="edit-details-from-wrapper">
							<?php echo $this->Form->create($existing_data,['role'=>'Form', 'novalidate'=>'novalidate', 'id'=>'edit_question_comment_form', 'class'=>'edit_profile_form', 'novalidate' => 'novalidate']); ?>
								<div class="row from-row">
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label for="">Question</label>
											<?php echo $this->Form->input('title',['type'=>'text', 'placeholder'=>'Question', 'label'=>false, 'class'=>'form-control', 'value'=>$existing_data['question']['name'], 'readonly']); ?>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group">
										<label for="">Comment</label>
										<?php echo $this->Form->input('comment',['type'=>'textarea', 'id'=>'comment', 'placeholder'=>'Comment', 'label'=>false, 'class'=>'form-control', 'value'=>$existing_data['comment']]); ?>										
									</div>
								</div>
								<div class="button-set">								
									<input type="submit" value="Update" class="btn-normal">&nbsp;
									<a href="<?php echo Router::url(array('controller'=>'/','action'=>'view-submissions'));?>" class="btn-cancel">Cancel</a>
								</div>							  
							<?php echo $this->Form->end();?>
							<div id="edit_profile_error_msg"></div>
							<div id="edit_profile_loader" style="text-align:center;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<script>
$(document).ready(function(){
	setTimeout(function(){
		$('#edit_profile_msg').html('');
	},5000);
});
$('#edit_question_comment_form').validate({
	rules: {
		comment: 'required',
	}
});
</script>