<?php
use Cake\Routing\Router;
$session  = $this->request->session();
?>
<div class="genpage-user-system">
    <div class="container">
		<div class="title">
			<h1>Edit Question Answer</h1>
		</div>
		<div class="genpage-wrapper">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="user-profile-details">
						<div id="edit_profile_msg"><?php echo $this->Flash->render();?></div>
						<div class="edit-details-from-wrapper">
							<?php echo $this->Form->create($existing_data,['role'=>'Form', 'novalidate'=>'novalidate', 'id'=>'edit_question_answer_form', 'class'=>'edit_profile_form', 'novalidate' => 'novalidate']); ?>
							
								<input type="hidden" name="questionanswerid" id="questionanswerid" value="<?php echo $existing_data->id;?>" />
							
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
										<label>Learning Path recommendation</label>                			
										<?php echo $this->Form->input('learning_path_recommendation',['type'=>'textarea', 'id'=>'recomandation', 'label'=>false, 'class'=>'texarea', 'required'=>true]);?>
										<small style="float: right; color:#999;">
											<span id="saving_draft_learning_path_recommendation" class="draft_msg"></span>
										</small>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group">
										<label for="">What was your learning experience</label>
										<?php echo $this->Form->input('learning_experience',['type'=>'textarea', 'id'=>'learning-experience', 'label'=>false, 'class'=>'texarea', 'required'=>true]); ?>
										<small style="float: right; color:#999;">
											<span id="saving_draft_learning_experience" class="draft_msg"></span>
										</small>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group">
										<label for="">What was your learning utility</label>
										<?php echo $this->Form->input('learning_utility',['type'=>'textarea', 'id'=>'utility', 'label'=>false, 'class'=>'texarea', 'required'=>true]); ?>
										<small style="float: right; color:#999;">
											<span id="saving_draft_learning_utility" class="draft_msg"></span>
										</small>
									</div>
								</div>
								<div class="button-set">								
									<input type="submit" value="<?php if($existing_data->status=='D')echo 'Update & Publish';else echo 'Update';?>" class="btn-normal">&nbsp;
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
$('#edit_question_answer_form').validate({
	rules: {
		comment: 'required',
	}
});
</script>

<?php
if(!empty($Auth)){
?>
<script>
//setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 2000;  //time in ms, 2 second for example
//Learning Path Recommendation
$(document).ready(function(){
	$('#recomandation').summernote({
		popover: {
			image: [],
			link: [],
			air: []
		},
		height:250,
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'italic', 'underline', 'clear']],
			['fontname', ['fontname']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['insert', ['link', 'hr']],
			['view', ['fullscreen', 'codeview']],
			//['help', ['help']]
		],
		placeholder:'What particular learning path, i.e. a succession of learning steps, courses, bootcamps, coachings or any other learning means would you recommend given the starting level, budget and other constraints and preferences?',
		callbacks: {
			onKeyup: function(e) {
				clearTimeout(typingTimer);
				typingTimer = setTimeout(doneTypingLearningPathRecomandation, doneTypingInterval);			
			},
			onKeydown: function(e) {
				clearTimeout(typingTimer);
			}
		}
	});
});
function doneTypingLearningPathRecomandation () {
	var website_url = '<?php echo Router::url("/questions/edit-submitted-question-answer-draft/",true); ?>';
	$('#saving_draft_learning_path_recommendation').html('Saving...');
	$.ajax({
		type : 'POST',
		url  : website_url,
		data : $('#edit_question_answer_form').serialize(),
		success : function(response){
			if(response==1)
				$('#saving_draft_learning_path_recommendation').html('Saved as draft');
			else if(response==0)
				$('#saving_draft_learning_path_recommendation').html('Some error occured');
		},
		error : function(){
		}
	});
	setTimeout(function(){
		$('.draft_msg').html('');
	},3000);
}

//What Was Your Learning Experience
$(document).ready(function(){
	$('#learning-experience').summernote({	
		popover: {
			image: [],
			link: [],
			air: []
		},
		height:250,
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'italic', 'underline', 'clear']],
			['fontname', ['fontname']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['insert', ['link', 'hr']],
			['view', ['fullscreen', 'codeview']],
			//['help', ['help']]
		],
		placeholder:'How would you describe your experience, or review of the courses and learning steps per the recommended Learning Path',
		callbacks: {
			onKeyup: function(e) {
				clearTimeout(typingTimer);
				typingTimer = setTimeout(doneTypingLearningExperience, doneTypingInterval);			
			},
			onKeydown: function(e) {
				clearTimeout(typingTimer);
			}
		}
	});
});
function doneTypingLearningExperience () {
	var website_url = '<?php echo Router::url("/questions/edit-submitted-question-answer-draft/",true); ?>';
	$('#saving_draft_learning_experience').html('Saving...');
	$.ajax({
		type : 'POST',
		url  : website_url,
		data : $('#edit_question_answer_form').serialize(),
		success : function(response){
			if(response==1)
				$('#saving_draft_learning_experience').html('Saved as draft');
			else
				$('#saving_draft_learning_experience').html('Some error occured');
		},
		error : function(){
		}
	});
	setTimeout(function(){
		$('.draft_msg').html('');
	},3000);
}

//What Was Your Learning Utility
$(document).ready(function(){
	$('#utility').summernote({	
		popover: {
			image: [],
			link: [],
			air: []
		},
		height:250,
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'italic', 'underline', 'clear']],
			['fontname', ['fontname']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['insert', ['link', 'hr']],
			['view', ['fullscreen', 'codeview']],
			//['help', ['help']]
		],
		placeholder:'Did the learning you experienced lead you to the effect you wanted – e.g., to being successful in finding a new job, in salary progression, in enjoyment or any other utility you promised to yourself',
		callbacks: {
			onKeyup: function(e) {
				clearTimeout(typingTimer);
				typingTimer = setTimeout(doneTypingLearningUtility, doneTypingInterval);			
			},
			onKeydown: function(e) {
				clearTimeout(typingTimer);
			}
		}
	});
});
function doneTypingLearningUtility () {
	var website_url = '<?php echo Router::url("/questions/edit-submitted-question-answer-draft/",true); ?>';
	$('#saving_draft_learning_utility').html('Saving...');
	$.ajax({
		type : 'POST',
		url  : website_url,
		data : $('#edit_question_answer_form').serialize(),
		success : function(response){
			if(response==1)
				$('#saving_draft_learning_utility').html('Saved as draft');
			else
				$('#saving_draft_learning_utility').html('Some error occured');
		},
		error : function(){
		}
	});
	setTimeout(function(){
		$('.draft_msg').html('');
	},3000);
}
</script>
<?php
}
?>