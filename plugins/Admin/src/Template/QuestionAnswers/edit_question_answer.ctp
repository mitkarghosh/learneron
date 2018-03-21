<?php use Cake\Routing\Router; $session = $this->request->session();
$this->assign('needEditor', true);
$this->assign('editor_id', '.editorClass');
?>
<style>.btn-default{width:auto !important;} .col-sm-1 .checkbox{display:block;} .attireMainNav{display:none;}</style>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Edit Answer
         <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <?php echo $this->Flash->render() ?>
   <?php
   echo $this->Form->create($existing_data, ['id' => 'edit-answer-form', 'novalidate' => 'novalidate']);
   ?>
    <div class="card card-block">
		<?php if(!empty($existing_data->user)){?>
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Posted By:
            </label>
            <div class="col-sm-4">
				<span class="form-control boxed"><?php echo $existing_data->user->name;?></span>
            </div>
        </div>
		<?php } ?>
	
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Learning Path recommendation:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('learning_path_recommendation', ['type' => 'textarea', 'required' => false, 'label' => false, 'class' => 'editorClass form-control boxed', 'placeholder' => '', 'value' => $existing_data->learning_path_recommendation]); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               What Was Your Learning Experience:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('learning_experience', ['type' => 'textarea', 'required' => false, 'label' => false, 'class' => 'editorClass form-control boxed', 'placeholder' => '', 'value' => $existing_data->learning_experience]); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               What Was Your Learning Utility:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('learning_utility', ['type' => 'textarea', 'required' => false, 'label' => false, 'class' => 'editorClass form-control boxed', 'placeholder' => '', 'value' => $existing_data->learning_utility]); ?>
            </div>
         </div>
		<?php
		if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionAnswers')))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('change-status'))==1 ){
		?>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Status:
            </label>
            <div class="col-sm-2">
               <?php echo $this->Form->input('status', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Status', 'options' => ['A' => 'Active', 'I' => 'Inactive']]); ?>
            </div>
         </div>
		<?php
		}
		?>
         <div class="form-group row">
            <div class="col-sm-10 col-sm-offset-2">
               <?php echo $this->Form->button('Update',['type' => 'submit','class' => 'btn btn-primary']); ?>&nbsp;
			   <a href="<?php echo Router::url('/admin/question-answers/list-data',true); ?>" class="btn btn-primary">Cancel</a>&nbsp;
				<a href="#" id="<?php echo $existing_data->id; ?>" data-toggle="modal" data-target="#suggestion-modal" title="Email to user" class="btn btn-primary" style="width: auto;">Reply to User</a>
            </div>
         </div>
      </div>
   <?php echo $this->Form->end(); ?>
</article>

<!-- /.modal -->
<div class="modal fade" id="suggestion-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-user"></i> <span class="blog_header">Reply to user</span></h4>
            </div>
            <div class="modal-body">
                <div class="detailsContent">
                  <p><b>User Name:</b> <span class="user_name"></span></p>
                  <p><b>Email:</b> <span class="email"></span></p>				  
                  <form name='reply' action="javascript:void(0);" id='reply' enctype="multipart/form-data" novalidate="novalidate">
					<textarea name="message" id="message" class="form-control boxed editorClass" required="required"></textarea>
                    <p class="err_mag"></p>
                    <div id="msg_div"></div>
					<input type="hidden" name="submitter_name" value="" id="submitter_name" />
                    <input type="hidden" name="email" id="email_contacts" value="" row='5' ><br>
                    <input type="submit" class="btn btn-primary btn-sm rounded-s" id="reply_user" value='Send'>
                  </form>
                </div>
                <div class="loading" style="display:none">
                  <p>Getting the data...</p>
                </div>
				<span id="reply_message"></span>
                <div class="error text-danger" style="display:none">
                  <p>There was an unexpected error. Try again later or contact the developers.</p>
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
	$(document).ready(function(){
		/* Reply user*/
		$('#reply_user').click(function(){
			var message = $('.panel-body').html();
			var cleanContent = message.replace(/(<([^>]+)>)/ig,"");
			if(cleanContent.length == 0){
				$('.err_mag').html('Please write something for the message').css({'color':'red'});
			}else{
				$("div#divLoading").addClass('show');
				$('.err_mag').html('');
				var email = $('#email_contacts').val();
				var submitter_name = $('#submitter_name').val();
				var message = $('#message').val();
				$.ajax({
					type: 'POST',
					dataType: 'JSON',
					url: '<?php echo Router::url("/admin/question-answers/reply-user/",true); ?>',
					data: {submitter_name: submitter_name, email: email, message: message},			
					success: function(result){
						$("div#divLoading").remove();
						if(result.status == 'mail_sent'){
							var msg = "<div class='message success' onclick='this.classList.add('hidden')'>Email has been successfully sent.</div>";
							$('#reply_message').html(msg);
							setTimeout(function(){
								$('#reply')[0].reset();
								$('#reply_message').html('');
								$('#suggestion-modal').modal('hide');
							},3000);
						}else{
							var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the developers.</div>";
							$('#reply_message').html(msg);
							setTimeout(function(){
								$('#reply')[0].reset();
								$('#reply_message').html('');
								$('#suggestion-modal').modal('hide');
							},3000);
						}
					}
				});
			}
		});
		/* End Reply user*/
		  var localStorage = [];
		  $('#suggestion-modal').on('shown.bs.modal', function (e) {
				var id = e.relatedTarget.id;
				$('.loading').hide();
				$('.error').hide();
				$('.detailsContent').show();
				$('.loading').show();
				$('.detailsContent').hide();
				var promise = $.getJSON('<?php echo Router::url("/admin/question-answers/view/",true); ?>'+id);
				promise.done(function(response){
					localStorage[id] = response.data;
					$('.loading').hide();
					$('.error').hide();
					$('.detailsContent').show();
					$('.user_name').text(response.data.user.name);
					$('#submitter_name').val(response.data.user.name);
					$('.email').text(response.data.user.email);
					$('#email_contacts').val(response.data.user.email);
					$('.message').text(response.user_message);
				  });
				promise.fail(function(response){
					$('.loading').hide();
					$('.detailsContent').hide();
					$('.error').show();
				  });
			});

		});
</script>