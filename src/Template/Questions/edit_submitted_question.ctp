<?php
use Cake\Routing\Router;
$session  = $this->request->session();
?>
<div class="genpage-user-system">
    <div class="container">      
		<div class="genpage-wrapper">
			<div class="row">          
				<div class="col-md-9 col-sm-8">
					<div class="title">
						<h1>Edit Question</h1>
					</div>
					<div class="page-body post-question-area">
						<div class="form-wrapper question-post-from">
							<?php echo $this->Form->create($existing_data,['id' => 'postquestion_settings_form', 'novalidate' => 'novalidate']); ?>
							
								<input type="hidden" name="questionid" id="questionid" value="<?php echo $existing_data->id;?>" />
							
								<div class="form-group">
									<label for="">Question Title</label>
									<?php echo $this->Form->input('name',['type'=>'text', 'id'=>'qstn_title', 'placeholder'=>'Question Title', 'label'=>false, 'class'=>'form-control', 'required'=>"required"]); ?>
									<small style="float: right; color:#999;">
										<span id="saving_draft" class="draft_msg"></span>
									</small>
								</div>
								<div class="form-group">
									<?php echo $this->Form->input('short_description',['type'=>'textarea', 'id'=>'short_description', 'placeholder'=>'What learning path / curriculum did take you / could take me from the starting level to goal line, if possible respecting my budget or other constraints and limitations?  What courses or other means or learning, and with what succession?', 'label'=>false, 'class'=>'form-control']); ?>
									<small style="float: right; color:#999;">
										<span id="saving_draft_short_description" class="draft_msg"></span>
									</small>
								</div>
								<div class="form-group">
									<label for="">Learning Goal</label>
									<?php echo $this->Form->input('learning_goal',['type'=>'textarea', 'id'=>'learning-goal', 'label'=>false, 'class'=>'texarea learninggoal']); ?>
									<small style="float: right; color:#999;">
										<span id="saving_draft_learning_goal" class="draft_msg"></span>
									</small>
								</div>
								<div class="form-group">
									<label for="">Starting Level
								<?php if(!empty($Auth)){ ?>
									<a href="javascript:void(0);" class="btn-normal btn-copy" id="get_education_details" title="Copy from my account settings Education History">Copy from Education History</a>
								<?php } ?>
									</label><span id="data_loader"></span>
									<?php echo $this->Form->input('education_history',['type'=>'textarea', 'id'=>'education-history', 'placeholder'=>'', 'label'=>false, 'class'=>'form-control']); ?>
									<small style="float: right; color:#999;">
										<span id="saving_draft_education_history" class="draft_msg"></span>
									</small>
								</div>
								<div class="form-group">
									<label for="">Budget & other constraints</label>
									<?php echo $this->Form->input('budget_constraints',['type'=>'textarea', 'id'=>'budget_constraints', 'label'=>false, 'class'=>'texarea budgetconstraints']); ?>
									<small style="float: right; color:#999;">
										<span id="saving_draft_budget_constraints" class="draft_msg"></span>
									</small>
								</div>
								<div class="form-group">
									<label for="">Optional input on preferred learning mode </label>
									<?php echo $this->Form->input('preferred_learning_mode',['type'=>'textarea', 'id'=>'preferred_learning_mode', 'label'=>false, 'class'=>'texarea preferredlearningmode']); ?>
									<small style="float: right; color:#999;">
										<span id="saving_draft_preferred_learning_mode" class="draft_msg"></span>
									</small>
								</div>
								<div class="tag-insert-sections">
									<?php
									$tag_ids = array();
									if(!empty($existing_data->question_tags)){
										foreach($existing_data->question_tags as $val){
											$tag_ids[] = $val['tag_id'];
										}
									}
									?>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Tags</label>
												<?php echo $this->Form->input('tags', ['type'=>'select', 'empty'=>'', 'options'=>$all_tags, 'label' => false, 'class' => 'multipleSelectTags form-control', 'placeholder' => 'Tags', 'value'=>$tag_ids, 'multiple'=>true, 'required'=>true ]); ?>
												<small style="float: right; color:#999;">
													<span id="saving_draft_tags" class="draft_msg"></span>
												</small>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Select Category</label>
												<select name="category_id" id="category_id" class="form-control" required>
													<option value="">Select</option>
												<?php
												foreach($question_categories as $key_category => $val_category){
												?>
													<option value="<?php echo $key_category;?>" <?php if($key_category==$existing_data->category_id)echo 'selected';?>><?php echo $val_category;?></option>
												<?php
												}
												?>
												</select>
												<small style="float: right; color:#999;">
													<span id="saving_draft_category_id" class="draft_msg"></span>
												</small>
											</div>
										</div>
									</div>
								</div>
								<div class="check-box-set">
									<input type="checkbox" name="response_email" id="response_email" value="Y" autocomplete="off" <?php if($existing_data->response_email == 'Y'){echo 'checked';}?>>
									<label for="response_email">Send me new responses to my post via email</label>
								</div>
								<!--<div class="check-box-set">
									<input type="checkbox" name="is_featured" id="is_featured" value="Y" autocomplete="off">
									<label for="is_featured">Make featured question</label>
								</div>-->
								<div class="button-set">
									<input type="submit" class="btn-normal" value="<?php if($existing_data->status=='D')echo 'Update & Publish';else echo 'Update';?>">&nbsp;
									<a href="<?php echo Router::url(array('controller'=>'/','action'=>'view-submissions'));?>" class="btn-cancel">Cancel</a>
								</div>								
							<?php echo $this->Form->end();?>
						</div>
					</div>
				</div>          
				<div class="col-md-3 col-sm-4 question-right">
					<div class="question-instruction">
				<?php
				if(!empty($all_faqs)){
				?>					
						<div class="category side-bar-block" id="accordion">
							<h3>Question Posting Instructions</h3>              
							<ul>
				<?php		foreach($all_faqs as $faq){ ?>
								<li class="accordion-toggle"><?php echo $faq->question;?></li>
								<p class="accordion-content"><?php echo substr(strip_tags($faq->answer), 0, 200); if(strlen($faq->answer)>200){ echo '...<a href="faqs">more</a>'; }?></p>
				<?php		} ?>
							</ul>
						</div>
				<?php
				}
				?>
					</div>          	
				</div>				
			</div>
		</div>
    </div>
</div>
<script>
$('.multipleSelectTags').fastselect();

//For get education history
$('#get_education_details').click(function(){
    $("#data_loader").html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
	$.ajax({
	    url : "<?php echo Router::url("/questions/get-education_details/",true); ?>",
	    type: "POST",
	    success:function(response){
			$("#data_loader").html('');
			$('#education-history').val(response);	        
	    }
	});
});

$('#postquestion_settings_form').validate({
	rules: {
		short_description: 'required',
		short_description: 'required',
	}
});

$(document).ready(function($) {
    $('#accordion').find('.accordion-toggle').click(function(){
		//Expand or collapse this panel
		$(this).next().slideToggle('slow');
		//Hide the other panels
		$(".accordion-content").not($(this).next()).slideUp('slow');
    });
});
</script>

<?php
if(!empty($Auth)){
?>
	<script>
	//setup before functions
	var typingTimer;                //timer identifier
	var doneTypingInterval = 2000;  //time in ms, 2 second for example
	var $input = $('#qstn_title');	
	//on keyup, start the countdown
	$input.on('keyup', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping, doneTypingInterval);
	});
	//on keydown, clear the countdown
	$input.on('keydown', function () {
		clearTimeout(typingTimer);
	});
	//user is "finished typing," do something
	function doneTyping () {
		if($input.val() !== ''){
			var website_url = '<?php echo Router::url("/questions/edit-submitted-question-draft/",true); ?>';
			$('#saving_draft').html('Saving...');
			$.ajax({
				type : 'POST',
				url  : website_url,
				data : $('#postquestion_settings_form').serialize(),
				success : function(response){
					if(response==1)
						$('#saving_draft').html('Saved as draft');
					else
						$('#saving_draft').html('Some error occured');
				},
				error : function(){
				}
			});			
			setTimeout(function(){
				$('.draft_msg').html('');
			},3000);
		}
	}
	
	var $short_description = $('#short-description');	
	$short_description.on('keyup', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping1, doneTypingInterval);
	});
	$short_description.on('keydown', function () {
		clearTimeout(typingTimer);
	});
	function doneTyping1 () {
		if($short_description.val() !== ''){
			var website_url = '<?php echo Router::url("/questions/post-question-submission-as-draft/",true); ?>';
			$('#saving_draft_short_description').html('Saving...');
			$.ajax({
				type : 'POST',
				url  : website_url,
				data : $('#postquestion_settings_form').serialize(),
				success : function(response){
					if(response==1)
						$('#saving_draft_short_description').html('Saved as draft');
					else
						$('#saving_draft_short_description').html('Some error occured');
				},
				error : function(){
				}
			});
			setTimeout(function(){
				$('.draft_msg').html('');
			},3000);
		}
	}
	
	//education-history
	var $education_history = $('#education-history');	
	$education_history.on('keyup', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping2, doneTypingInterval);
	});
	$education_history.on('keydown', function () {
		clearTimeout(typingTimer);
	});
	function doneTyping2 () {
		if($education_history.val() !== ''){
			var website_url = '<?php echo Router::url("/questions/post-question-submission-as-draft/",true); ?>';
			$('#saving_draft_education_history').html('Saving...');
			$.ajax({
				type : 'POST',
				url  : website_url,
				data : $('#postquestion_settings_form').serialize(),
				success : function(response){
					if(response==1)
						$('#saving_draft_education_history').html('Saved as draft');
					else
						$('#saving_draft_education_history').html('Some error occured');
				},
				error : function(){
				}
			});			
			setTimeout(function(){
				$('.draft_msg').html('');
			},3000);
		}
	}
	
	//Learning Goal
	$(document).ready(function(){
		$('#learning-goal').summernote({	
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
			placeholder:'What subject of learning and target level you want to achieve',
			callbacks: {
				onKeyup: function(e) {
					clearTimeout(typingTimer);
					typingTimer = setTimeout(doneTypingLearningGoal, doneTypingInterval);			
				},
				onKeydown: function(e) {
					clearTimeout(typingTimer);
				}
			}
		});
	});
	function doneTypingLearningGoal () {
		var website_url = '<?php echo Router::url("/questions/post-question-submission-as-draft/",true); ?>';
		$('#saving_draft_learning_goal').html('Saving...');
		$.ajax({
			type : 'POST',
			url  : website_url,
			data : $('#postquestion_settings_form').serialize(),
			success : function(response){
				if(response==1)
					$('#saving_draft_learning_goal').html('Saved as draft');
				else
					$('#saving_draft_learning_goal').html('Some error occured');
			},
			error : function(){
			}
		});
	}
	
	//Budget & Constraints
	$(document).ready(function(){
		$('#budget_constraints').summernote({	
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
			placeholder:'Please enter any monetary limits, timing constraints (eg, "available only on evenings"), language preferences, ability or not to travel for education and similar matters or preferences',
			callbacks: {
				onKeyup: function(e) {
					clearTimeout(typingTimer);
					typingTimer = setTimeout(doneTypingBudgetConstraints, doneTypingInterval);			
				},
				onKeydown: function(e) {
					clearTimeout(typingTimer);
				}
			}
		});
	});
	function doneTypingBudgetConstraints () {
		var website_url = '<?php echo Router::url("/questions/post-question-submission-as-draft/",true); ?>';
		$('#saving_draft_budget_constraints').html('Saving...');
		$.ajax({
			type : 'POST',
			url  : website_url,
			data : $('#postquestion_settings_form').serialize(),
			success : function(response){
				if(response==1)
					$('#saving_draft_budget_constraints').html('Saved as draft');
				else
					$('#saving_draft_budget_constraints').html('Some error occured');
			},
			error : function(){
			}
		});
		setTimeout(function(){
			$('.draft_msg').html('');
		},3000);
	}
	
	//Preferred Learning Mode
	$(document).ready(function(){
		$('#preferred_learning_mode').summernote({	
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
			placeholder:'Eg, learning by reading, learning by listening, learning by practicing, online interactive delivery, onsite in-person delivery in classroom set-up, one-on-one delivery or similar preference',
			callbacks: {
				onKeyup: function(e) {
					clearTimeout(typingTimer);
					typingTimer = setTimeout(doneTypingPreferredLearningMode, doneTypingInterval);			
				},
				onKeydown: function(e) {
					clearTimeout(typingTimer);
				}
			}
		});
	});	
	function doneTypingPreferredLearningMode () {
		var website_url = '<?php echo Router::url("/questions/post-question-submission-as-draft/",true); ?>';
		$('#saving_draft_preferred_learning_mode').html('Saving...');
		$.ajax({
			type : 'POST',
			url  : website_url,
			data : $('#postquestion_settings_form').serialize(),
			success : function(response){
				if(response==1)
					$('#saving_draft_preferred_learning_mode').html('Saved as draft');
				else
					$('#saving_draft_preferred_learning_mode').html('Some error occured');
			},
			error : function(){
			}
		});
		setTimeout(function(){
			$('.draft_msg').html('');
		},3000);
	}
	
	var $input_tags = $('#tags');	
	$input_tags.on('change', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping3, doneTypingInterval);
	});
	function doneTyping5 () {
		if($input_tags.val() !== ''){
			var website_url = '<?php echo Router::url("/questions/post-question-submission-as-draft/",true); ?>';
			$('#saving_draft_tags').html('Saving...');
			$.ajax({
				type : 'POST',
				url  : website_url,
				data : $('#postquestion_settings_form').serialize(),
				success : function(response){
					if(response==1)
						$('#saving_draft_tags').html('Saved as draft');
					else
						$('#saving_draft_tags').html('Some error occured');
				},
				error : function(){
				}
			});
			setTimeout(function(){
				$('.draft_msg').html('');
			},3000);
		}
	}
	
	var $input_category_id = $('#category_id');	
	$input_category_id.on('change', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping3, doneTypingInterval);
	});
	function doneTyping3 () {
		if($input_category_id.val() !== ''){
			var website_url = '<?php echo Router::url("/questions/post-question-submission-as-draft/",true); ?>';
			$('#saving_draft_category_id').html('Saving...');
			$.ajax({
				type : 'POST',
				url  : website_url,
				data : $('#postquestion_settings_form').serialize(),
				success : function(response){
					if(response==1)
						$('#saving_draft_category_id').html('Saved as draft');
					else
						$('#saving_draft_category_id').html('Some error occured');
				},
				error : function(){
				}
			});
			setTimeout(function(){
				$('.draft_msg').html('');
			},3000);
		}
	}
	
	var $input_new_tags = $('#new-tags');	
	$input_new_tags.on('keyup', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping4, doneTypingInterval);
	});
	$input_new_tags.on('keydown', function () {
		clearTimeout(typingTimer);
	});
	function doneTyping4 () {
		if($input_new_tags.val() !== ''){
			var website_url = '<?php echo Router::url("/questions/post-question-submission-as-draft/",true); ?>';
			$('#saving_draft_new_tags').html('Saving...');
			$.ajax({
				type : 'POST',
				url  : website_url,
				data : $('#postquestion_settings_form').serialize(),
				success : function(response){
					if(response==1)
						$('#saving_draft_new_tags').html('Saved as draft');
					else
						$('#saving_draft_new_tags').html('Some error occured');
				},
				error : function(){
				}
			});
			setTimeout(function(){
				$('.draft_msg').html('');
			},3000);
		}
	}
	
	$('#response_email').click(function(){
		var website_url = '<?php echo Router::url("/questions/post-question-submission-as-draft/",true); ?>';
		if($('#response_email').is(":checked")){			
			$.ajax({
				type : 'POST',
				url  : website_url,
				data : {response_email : 'Y'},
				success : function(response){					
				},
				error : function(){
				}
			});
		}else{
			$.ajax({
				type : 'POST',
				url  : website_url,
				data : {response_email : 'N'},
				success : function(response){					
				},
				error : function(){
				}
			});
		}
	});
	</script>
<?php
}
?>