<?php
use Cake\Routing\Router;
$session  = $this->request->session();
?>
<div class="genpage-user-system">
    <div class="container">
		<div class="title">
			<h1>Edit Question Answer Comment</h1>
		</div>
		<div class="genpage-wrapper">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="user-profile-details">
						<div id="edit_profile_msg"><?php echo $this->Flash->render();?></div>
						<div class="edit-details-from-wrapper">
							<?php echo $this->Form->create($existing_data,['role'=>'Form', 'novalidate'=>'novalidate', 'id'=>'edit_question_answer_comment_form', 'class'=>'edit_profile_form', 'novalidate' => 'novalidate']); ?>
								<input type="hidden" name="questionanswercommentid" id="questionanswercommentid" value="<?php echo $existing_data->id;?>" />
								<div class="row from-row">
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label for="">Question</label>
											<?php echo $this->Form->input('title',['type'=>'text', 'placeholder'=>'Question', 'label'=>false, 'class'=>'form-control', 'value'=>$existing_data['question']['name'], 'readonly']); ?>
										</div>
									</div>
								</div>
								<div class="row from-row">
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label for="">Answer (Learning Path recommendation)</label>
											<?php echo $this->Form->input('title',['type'=>'textarea', 'placeholder'=>'Question', 'label'=>false, 'class'=>'form-control', 'value'=>strip_tags($existing_data['question_answer']['learning_path_recommendation']), 'readonly']); ?>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group">
										<label for="">Comment</label>
										<?php echo $this->Form->input('comment',['type'=>'textarea', 'id'=>'comment', 'placeholder'=>'Comment', 'label'=>false, 'class'=>'form-control', 'value'=>$existing_data['comment']]); ?>
										<small style="float: right; color:#999;">
											<span id="saving_draft_question_answer_comment" class="draft_msg"></span>
										</small>
									</div>
								</div>
								<div class="button-set">								
									<input type="submit" value="<?php if($existing_data->status=='2')echo 'Update & Publish';else echo 'Update';?>" class="btn-normal">&nbsp;
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
$('#edit_question_answer_comment_form').validate({
	rules: {
		comment: 'required',
	}
});
</script>

<?php
if( !empty($Auth) ) {
?>
<script>
//setup before functions
var typingTimer1;                //timer identifier
var doneTypingInterval1 = 2000;  //time in ms, 2 second for example
var $comment = $('#comment');
$(document).ready(function(){
	$comment.on('keyup', function () {
		clearTimeout(typingTimer1);
		typingTimer1 = setTimeout(doneTypingQComment, doneTypingInterval1);
	});
	
	$comment.on('keydown', function () {
		clearTimeout(typingTimer1);
	});
});
function doneTypingQComment () {
	if($comment.val() !== ''){
		var website_url = '<?php echo Router::url("/questions/edit-submitted-question-answer-comment-draft/",true); ?>';
		$('#saving_draft_question_answer_comment').html('Saving...');
		$.ajax({
			type : 'POST',
			url  : website_url,
			data : $('#edit_question_answer_comment_form').serialize(),
			success : function(response){
				if(response==1)
					$('#saving_draft_question_answer_comment').html('Saved as draft');
				else if(response==0)
					$('#saving_draft_question_answer_comment').html('Some error occured');
				else if(response==2)
					$('#saving_draft_question_answer_comment').html('');
			},
			error : function(){
			}
		});			
		setTimeout(function(){
			$('.draft_msg').html('');
		},3000);
	}
}
</script>
<?php
}
?>