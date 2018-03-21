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
								<div class="form-group">
									<label for="">Question Title</label>
									<?php echo $this->Form->input('name',['type'=>'text', 'placeholder'=>'Question Title', 'label'=>false, 'class'=>'form-control', 'required'=>"required"]); ?>
								</div>
								<div class="form-group">
									<?php echo $this->Form->input('short_description',['type'=>'textarea', 'id'=>'short_description', 'placeholder'=>'What learning path / curriculum did take you / could take me from the starting level to goal line, if possible respecting my budget or other constraints and limitations?  What courses or other means or learning, and with what succession?', 'label'=>false, 'class'=>'form-control']); ?>
								</div>
								<div class="form-group">
									<label for="">Learning Goal</label>
									<?php echo $this->Form->input('learning_goal',['type'=>'textarea', 'id'=>'learning-goal', 'label'=>false, 'class'=>'texarea']); ?>
								</div>
								<div class="form-group">
									<label for="">Starting Level
								<?php if(!empty($Auth)){ ?>
									<a href="javascript:void(0);" class="btn-normal btn-copy" id="get_education_details" title="Copy from my account settings Education History">Copy from Education History</a>
								<?php } ?>
									</label><span id="data_loader"></span>
									<?php echo $this->Form->input('education_history',['type'=>'textarea', 'id'=>'education-history', 'placeholder'=>'', 'label'=>false, 'class'=>'form-control']); ?>
								</div>
								<div class="form-group">
									<label for="">Budget & other constraints</label>
									<?php echo $this->Form->input('budget_constraints',['type'=>'textarea', 'id'=>'budget_constraints', 'label'=>false, 'class'=>'texarea']); ?>
								</div>
								<div class="form-group">
									<label for="">Optional input on preferred learning mode </label>
									<?php echo $this->Form->input('preferred_learning_mode',['type'=>'textarea', 'id'=>'preferred_learning_mode', 'label'=>false, 'class'=>'texarea']); ?>
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
									<input type="submit" class="btn-normal" value="Update">&nbsp;
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