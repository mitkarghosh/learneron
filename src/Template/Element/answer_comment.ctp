<?php
use Cake\Routing\Router;
?>
<!------------- For POST ANSWER-COMMENT-VOTE SECTION START ---------------->
<div class="modal fade" id="answer-comment-form-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Share a comment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php
			echo $this->Form->create(false, array('url'=>'javascript:void(0)', 'novalidate' => 'novalidate', 'id'=>'answer_comment_form'));
				echo $this->Form->input('question_id',['type'=>'hidden', 'label'=>false, 'class'=>'form-control','value'=>base64_encode($detail->id)]);
				echo $this->Form->input('answer_id',['type'=>'hidden', 'id'=>'answer_id', 'label'=>false, 'class'=>'form-control','value'=>'']);
				echo $this->Form->input('answer_user_id',['type'=>'hidden', 'id'=>'answer_user_id', 'label'=>false, 'class'=>'form-control','value'=>'']);
			?>
			<div class="modal-body">				
				<div class="form-group">
					<?php echo $this->Form->input('answer_comment',['type'=>'textarea', 'placeholder'=>'Post your comment', 'label'=>false, 'class'=>'form-control', 'required'=>true]);?>
					<small style="float: right; color:#999;">
						<span id="saving_draft_answer_comment" class="draft_msg"></span>
					</small>
				</div>
				<div id="answer_comment_msg"></div>
			</div>
			<div id="answer_comment_loader" style="text-align:center"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-alt" data-dismiss="modal">Close</button>
				<input type="submit" class="btn btn-normal" value="Submit">
			</div>
			<?php echo $this->Form->end();?>
		</div>
	</div>
</div>

<script>
function post_answer_comment(question_id,answer_id,answer_user_id,type){
	if(type == 1){
		$('#answer_id').val(answer_id);
		$('#answer_user_id').val(answer_user_id);
		$('#answer-comment-form-popup').modal('show');
	}
}
//Question comment form start here
$('#answer_comment_form').validate({
	submitHandler:function(){
		$('#answer_comment_loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var data = $('#answer_comment_form').serialize();
		var promise = $.post('<?php echo Router::url("/questions/post-answer-comment/",true); ?>',data);
		promise.done(function(response){
			var data = JSON.parse(response);
			$('#answer_comment_loader').html('');
			if(data.submission=='user_not_logged_in'){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Login required to post answer comment.</div>";
				$('#answer_comment_msg').html(msg);
				$('#answer_comment_form')[0].reset();
				setTimeout(function(){
					$('#answer_comment_msg').html('');
					$('#answer-comment-form-popup').modal('hide');
					$('#comment_vote').modal('show');
			  },5000);
			}else if(data.submission=='already_posted'){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Your comment for this answer is already posted.</div>";
				$('#answer_comment_msg').html(msg);
				$('#answer_comment_form')[0].reset();
				setTimeout(function(){
					$('#answer_comment_msg').html('');
					$('#answer-comment-form-popup').modal('hide');
			  },5000);
			}else if(data.submission=='success'){
				var msg = "<div class='message success' onclick='this.classList.add('hidden')'>Comment has been successfully submitted.</div>";
				$('#answer_comment_msg').html(msg);
				$('#answer_comment_form')[0].reset();
				setTimeout(function(){
					$('#answer_comment_msg').html('');
					$('#answer-comment-form-popup').modal('hide');
					window.location.reload();
			  },3000);
			}else if(data.submission=='success_approval'){
				var msg = "<div class='message success' onclick='this.classList.add('hidden')'>Comment has been successfully submitted. It needs Admin approval.</div>";
				$('#answer_comment_msg').html(msg);
				$('#answer_comment_form')[0].reset();
				setTimeout(function(){
					$('#answer_comment_msg').html('');
					$('#answer-comment-form-popup').modal('hide');
			  },5000);
			}else if(data.submission=='same_user'){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Your cannot post comment to your own answer.</div>";
				$('#answer_comment_msg').html(msg);
				$('#answer_comment_form')[0].reset();
				setTimeout(function(){
					$('#answer_comment_msg').html('');
					$('#answer-comment-form-popup').modal('hide');
			  },5000);
			}else{
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
				$('#answer_comment_msg').html(msg);
				setTimeout(function(){
					$('#answer_comment_msg').html('');
				},5000);
			}
		});
		promise.fail(function(){
			var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
			$('#answer_comment_msg').html(msg);
			setTimeout(function(){
				$('#answer_comment_msg').html('');
			},5000);
		});		
	}
});
//answer comment form end here

//Upvote section start here
function upvote_answer(question_id,answer_id,answer_user_id){
	$('#upvote_loader_'+question_id+'_'+answer_id).html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
	$.ajax({
		url:"<?php echo Router::url("/questions/ajax-answer-upvote/",true); ?>",
		type: 'POST',
		data: {question_id : question_id, answer_id : answer_id, answer_user_id : answer_user_id},
		success: function(data){
			$('#upvote_loader_'+question_id+'_'+answer_id).html('');
			if(data=='user_not_logged_in'){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Login required to give vote.</div>";
				$('#upvote_loader_'+question_id+'_'+answer_id).html(msg);
				setTimeout(function(){
					$('#upvote_loader_'+question_id+'_'+answer_id).html('');
				},5000);
			}else if(data=='already_posted'){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Your vote for this answer is already done.</div>";
				$('#upvote_loader_'+question_id+'_'+answer_id).html(msg);
				setTimeout(function(){
					$('#upvote_loader_'+question_id+'_'+answer_id).html('');
				},5000);
			}else if(data=='success'){
				var previout_vote_count = $('#vote_'+question_id+'_'+answer_id).html();
				var new_vote_count = parseInt(previout_vote_count) + 1;
				$('#vote_'+question_id+'_'+answer_id).html(new_vote_count);
				var msg = "<div class='message success' onclick='this.classList.add('hidden')'>Thank you for voting.</div>";
				$('#upvote_loader_'+question_id+'_'+answer_id).html(msg);
				var total_count = 0;
				$('.vote_'+question_id).each(function(){
					total_count += parseInt($(this).text());
				});
				$('#total_votes').html(total_count);
				setTimeout(function(){
					$('#upvote_loader_'+question_id+'_'+answer_id).html('');
				},5000);
			}else if(data=='same_user'){
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>Your cannot give vote to your own answer.</div>";
				$('#upvote_loader_'+question_id+'_'+answer_id).html(msg);
				setTimeout(function(){
					$('#upvote_loader_'+question_id+'_'+answer_id).html('');
				},5000);
			}else{
				var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
				$('#upvote_loader_'+question_id+'_'+answer_id).html(msg);
				setTimeout(function(){
					$('#upvote_loader_'+question_id+'_'+answer_id).html('');
				},5000);
			}
		}
	});
}
//Upvote section end here
</script>
<!------------- For POST ANSWER-COMMENT-VOTE SECTION END ---------------->
