<?php
use Cake\Routing\Router;
$session = $this->request->session();
?>
<div class="genpage-user-system">
    <div class="container">
		<div class="title">
			<h1>Edit News Comment</h1>
		</div>
		<div class="genpage-wrapper">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="user-profile-details">
						<div id="edit_profile_msg"><?php echo $this->Flash->render();?></div>
						<div class="edit-details-from-wrapper">
							<?php echo $this->Form->create($existing_data,['role'=>'Form', 'novalidate'=>'novalidate', 'id'=>'edit_news_comment_form', 'class'=>'edit_profile_form', 'novalidate' => 'novalidate']); ?>
								<div class="row from-row">
									<div class="col-md-12 col-sm-12">
										<div class="form-group">
											<label for="">News</label>
											<?php echo $this->Form->input('title',['type'=>'text', 'placeholder'=>'Question', 'label'=>false, 'class'=>'form-control', 'value'=>$existing_data['news']['name'], 'readonly']); ?>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group">
										<label for="">Comment</label>
										<?php echo $this->Form->input('comment',['type'=>'textarea', 'id'=>'comment', 'placeholder'=>'Comment', 'label'=>false, 'class'=>'form-control', 'value'=>$existing_data['comment']]); ?>
										<small style="float: right; color:#999;">
											<span id="saving_draft"></span>
										</small>
									</div>
								</div>
								<div class="button-set">								
									<input type="submit" value="<?php if($existing_data->status==2)echo 'Update & Publish';else echo 'Update';?>" class="btn-normal">&nbsp;
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
$('#edit_news_comment_form').validate({
	rules: {
		comment: 'required',
	}
});

<?php
if(!empty($Auth)){
?>
	//setup before functions
	var typingTimer;                //timer identifier
	var doneTypingInterval = 3000;  //time in ms, 3 second for example
	var $input = $('#comment');	
	
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
			var news_comment = $.trim($input.val());		
			var newsid = $('#news-id').val();			
			var website_url = '<?php echo Router::url("/news/edit-submitted-news-comment-draft/",true); ?>';
			$('#saving_draft').html('Saving...');
			$.ajax({
				type : 'POST',
				url  : website_url,
				data : { comment : news_comment, news_comment_id : <?php echo $existing_data->id;?> },
				success : function(response){
					if(response==1)
						$('#saving_draft').html('Saved as draft');
					else
						$('#saving_draft').html('Some error occured');
				},
				error : function(){
				}
			});
		}
	}
<?php
}
?>
</script>