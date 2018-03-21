<?php use Cake\Routing\Router; $session = $this->request->session(); ?>
<style>
.right-gap{margin-right:10px;}
.top-gap{margin-top:10px;}
</style>
<article class="content items-list-page">
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-9">
               <h3 class="title">
                  Question Answers
				  <a>&nbsp;</a>
               </h3>
            </div>
         </div>
      
      <div style="float:left;">
			<div class="clearfix">&nbsp;</div>
         <form class="form-inline" action="<?php echo Router::url('/admin/question-answers/list-data',true); ?>" method="get">
            <div class="input-group">
               <span>
                  <input value="<?php if($this->request->query('search') !== null): echo $this->request->query('search'); endif; ?>" type="text" name="search" class="form-control boxed rounded-s right-gap" placeholder="Search by answer title..." />
                </span>
				<span>
                  <input value="<?php if($this->request->query('search_by') !== null): echo $this->request->query('search_by'); endif; ?>" type="text" name="search_by" class="form-control boxed rounded-s right-gap" placeholder="Search by question title..." />
                </span>				
			   <span>
                   <select class="form-control right-gap" name="search_by_answerid" style="height:39px;">
                     <option value="">Select id</option>
				<?php
					if(!empty($all_question_answer_ids)){
						foreach($all_question_answer_ids as $val_qcu){
				?>
							<option value="<?php echo $val_qcu;?>"><?php echo $val_qcu;?></option>
				<?php
						}
					}
				?>
                   </select>
                   <?php if($this->request->query('search_by_answerid') !== NULL): ?>
						  <script type="text/javascript">
							$('select[name="search_by_answerid"]').val("<?php echo $this->request->query('search_by_answerid'); ?>");
						  </script>
                    <?php endif; ?>
               </span>
			   <span class="input-group-btn">
                   <button class="btn btn-secondary rounded-s" type="submit" title="Search">
                        <i class="fa fa-search"></i>
                   </button>
				   <a title="Reset" class="btn btn-secondary rounded-s" href="<?php echo Router::url('/admin/question-answers/list-data',true);?>">
						<i class="fa fa-refresh"></i>
					</a>
               </span>
            </div>
         </form>
		 </div>
      </div>
   </div>
   <div class="card items">
   <?php echo $this->Flash->render() ?>
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
               <div class="item-col fixed item-col-check">
               <?php if(!empty($answer_details)): ?>
                  <label class="item-check" id="select-all-items">
                      <input type="checkbox" class="checkbox">
                      <span></span>
                  </label> 
                <?php endif; ?>
               </div>
               <div class="item-col item-col-header item-col-name">               
                  <div> <span><a>Answer</a></span> </div>                  
               </div>
			   <div class="item-col item-col-header item-col-user">               
                  <div> <span><a>User</a></span> </div>                  
               </div>
				<div class="item-col item-col-header item-col-parent">
					<div> <span><a>Question</a></span></div>
				</div>
				<div class="item-col item-col-header item-col-featured">
					<?php if($this->request->query('sort') == 'created' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'created' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('created', $sortOrder,['escape' => false]); ?>
					<div> <span><?php echo $this->Paginator->sort('created', 'Added On'); ?></span> </div>					
				</div>
               <div class="item-col item-col-header item-col-status">
               <?php if($this->request->query('sort') == 'status' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'status' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('status', $sortOrder,['escape' => false]); ?>
                  <div> <span><?php echo $this->Paginator->sort('status', 'Status'); ?></span> </div>
                  
               </div>
               
               <div class="item-col item-col-header fixed item-col-actions-dropdown"> <span><a>Action</a></span> </div>
            </div>
         </li>
         <?php
         if(empty($answer_details)): ?>
            <li class="item">
                    <div class="item-row">
                       <div>No results found</div>
                    </div>
                 </li>
         <?php
         endif;
          foreach($answer_details as $answer): ?>
			<li class="item table-data" id="row_id_<?php echo $answer->id;?>">
			<div class="item-row">
			   <div class="item-col fixed item-col-check"> <label class="item-check">
				  <input type="checkbox" class="checkbox" value="<?php echo $answer->id; ?>">
				  <span></span>
				  </label> 
			   </div>
			   <div class="item-col item-col-name">
				  <div class="item-heading">Answer</div>
				  <div><?php echo substr($answer->learning_path_recommendation, 0, 100); if(strlen($answer->learning_path_recommendation)>100){ echo '...'; } ?></div>
			   </div>
			   <div class="item-col item-col-user">
				  <div class="item-heading">User</div>
				  <div><?php echo $answer->user->name?></div>
			   </div>
			   <div class="item-col item-col-parent">
				  <div class="item-heading">Question</div>
				  <div><?php if($answer->question->name != '') echo substr($answer->question->name, 0, 100); else echo 'N/A'; if(strlen($answer->question->name)>100){ echo '...'; } ?> </div>
			   </div>
			   <div class="item-col item-col-featured">
				  <div class="item-heading">Added On</div>
				  <div><?php if($answer->created != ''): echo date('jS F Y', strtotime($answer->created)); else: echo "N/A"; endif; ?> </div>
			   </div>
			   <div class="item-col item-col-status">
				  <div class="item-heading">Status</div>
				  <div data-id="status<?php echo $answer->id; ?>">  <?php if($answer->status == 'I'): echo "<b>Inactive</b>"; else: echo "Active"; endif; ?> </div>
			   </div>
			   <div class="item-col fixed item-col-actions-dropdown">
				  <div class="item-actions-dropdown active">
					 <div class="item-actions-block options">
						<ul class="item-actions-list">
						<?php
						if( (array_key_exists('edit-question-answer',$session->read('permissions.'.strtolower('QuestionAnswers')))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('edit-question-answer'))==1 ){
						?>
							<li>
							  <a class="edit" href="<?php echo Router::url("/admin/question-answers/edit-question-answer",true).'/'.base64_encode($answer->id); ?>" title="Edit"> 
								  <i class="fa fa-pencil"></i> 
							  </a>
						   </li>
						<?php
						}
						if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionAnswers')))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('change-status'))==1 ){
						?>
							<li>
							<?php if($answer->status == 'I'): ?>
								<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $answer->id; ?>','A');" title="Click to Active">
									<i class="fa fa-lock" aria-hidden="true"></i>
								</a>
							<?php else: ?>
								<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $answer->id; ?>','I');" title="Click to Inactive">
									<i class="fa fa-unlock" aria-hidden="true"></i>
								</a>
							<?php endif; ?>							 
						   </li><br />
						<?php
						}
						if( (array_key_exists('delete-question-answer',$session->read('permissions.'.strtolower('QuestionAnswers')))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('delete-question-answer'))==1 ){
						?>
						   <li class="top-gap">
								<a class="remove" href="javascript:void(0);" onclick="delete_question('<?php echo $answer->id; ?>');" title="Delete">
								<i class="fa fa-trash-o "></i> 
							  </a>
						   </li>
						<?php
						}
						if( (array_key_exists('list-data',$session->read('permissions.'.strtolower('AnswerComments')))) && $session->read('permissions.'.strtolower('AnswerComments').'.'.strtolower('list-data'))==1 ){
						?>
						   <li>
								<a class="info" href="<?php echo Router::url(['controller' => 'answer-comments', 'action' => 'list-data', base64_encode($answer->id)]); ?>" title="Comments" style="width:20px;">
								<i class="fa fa-comments-o"></i> <?php if(count($answer->answer_comment) != 0){echo '<span class="unapproved_comments"><span class="unapproved_comments_number">'.count($answer->answer_comment).'</span></span>';}?>
							  </a>
						   </li>
						<?php
						}
						?>
						  </ul>
					 </div>
				  </div>
			   </div>
			</div>
		 </li>

            <?php endforeach; ?>
      </ul>
   </div>
    <nav class="text-xs-left">
	<?php
	if($this->Paginator->param('count') != 0){
		$cnt = 1;
	}else{
		$cnt = 0;
	}
	$form = ($this->request->params['paging']['QuestionAnswers']['page'] * $this->request->params['paging']['QuestionAnswers']['perPage']) - $this->request->params['paging']['QuestionAnswers']['perPage']+$cnt;
	$to = ($this->request->params['paging']['QuestionAnswers']['page'] * $this->request->params['paging']['QuestionAnswers']['perPage'])-$this->request->params['paging']['QuestionAnswers']['perPage'] + $this->request->params['paging']['QuestionAnswers']['current']; ?>

    Showing | Total records: <?php echo $form.'-'.$to.' | '.$this->Paginator->param('count'); ?>
	</nav>
	<nav class="text-xs-right">
		<ul class="pagination">
		<?php
			echo $this->Paginator->prev('Prev');
			echo $this->Paginator->numbers();
			echo $this->Paginator->next('Next');
		?>
		</ul>
	</nav>
</article>
<style>
.unapproved_comments{background-color: #000; border-radius: 100% !important; color: #fff; height: auto !important; padding: 0px 5px !important; position: relative; right: 11px; text-align: center; top: -11px; vertical-align: top !important; width: auto !important; font-weight: normal;}
.unapproved_comments_blink{background-color: #caa961 !important;}
.unapproved_comments_number{font-size: 12px;}
</style>
<script type="text/javascript">
setInterval(function(){
	$('span.unapproved_comments').toggleClass('unapproved_comments_blink')
}, 800);

<?php
if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionAnswers')))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('change-status'))==1) && ((array_key_exists('delete-question-answer',$session->read('permissions.'.strtolower('QuestionAnswers')))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('delete-question-answer'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete','activeAll','Active','inactiveAll','Inactive');
<?php
}else if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionAnswers')))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('change-status'))==1) && ((!array_key_exists('delete-question-answer',$session->read('permissions.'.strtolower('QuestionAnswers')))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('delete-question-answer'))!=1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'activeAll','Active','inactiveAll','Inactive');
<?php
}
else if( ((!array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionAnswers')))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('change-status'))!=1) && ((array_key_exists('delete-question-answer',$session->read('permissions.'.strtolower('QuestionAnswers')))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('delete-question-answer'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete');
<?php
}
?>

function delete_question(id){
	swal({
	  title: "Are you sure? related comments and others will be deleted",
	  type: "error",
	  showCancelButton: true,
	  closeOnConfirm: false,
	  confirmButtonClass: 'btn-danger',
	  confirmButtonText: "Yes",
	  showLoaderOnConfirm: true
	}, function () {
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo Router::url("/admin/question-answers/delete-question-answer/",true); ?>',
			data: {id: id},			
			success: function(result) {
				if(result.type == 'success'){
					setTimeout(function () {
						$('#row_id_'+result.deleted_id).remove();
						swal({
							title: result.message,
							type: result.type,
							confirmButtonText: "Ok",
							},
							function(){
								window.location.reload();
							});
					}, 200);
				}else{
					setTimeout(function () {
						swal(result.message, "", "error");
					}, 200);
				}
			}
		});
	});
}
function deleteAll(){
	swal({
          title: "Are you sure?",
          type: "error",
          showCancelButton: true,
		  closeOnConfirm: false,
          confirmButtonClass: 'btn-danger',
          confirmButtonText: 'Yes',
		  showLoaderOnConfirm: true
        },
        function(){
			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				url: '<?php echo Router::url("/admin/question-answers/delete-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.delete_count == 1){	//all answers successfully deleted
						setTimeout(function () {
							//var data = $.parseJSON(result.deleted_ids);
							if(result.deleted_ids.length == 1){
								$('#row_id_'+result.deleted_ids).remove();
							}else{
								var data = result.deleted_ids;
								$.each(data, function(index,value){
									$('#row_id_'+value).remove();
								});
							}
							swal({
								title: result.message,
								type: result.type,
								confirmButtonText: "Ok",
								},
								function(){
									window.location.reload();
								});
						}, 500);
					}else{
						swal(result.message, "", "error");
					}
				}
			});
        });
}
function activeAll(){
	swal({
          title: "Are you sure?",
          type: "info",
          showCancelButton: true,
		  closeOnConfirm: false,
          confirmButtonClass: 'btn-info',
          confirmButtonText: 'Yes',
		  showLoaderOnConfirm: true
        },
        function(){
			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				url: '<?php echo Router::url("/admin/question-answers/active-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						setTimeout(function () {
							swal({
								title: "Answer(s) successfully activated",
								type: "success",
								confirmButtonText: "Ok",
								},
								function(){
									window.location.reload();
								});
						}, 500);						
					}else{
						swal("No answer(s) to mark as active", "", "warning");
					}
			   }
			});
        });
}
function inactiveAll(){
	swal({
          title: "Are you sure?",
          type: "warning",
          showCancelButton: true,
		  closeOnConfirm: false,
          confirmButtonClass: 'btn-warning',
          confirmButtonText: 'Yes',
		  showLoaderOnConfirm: true
        },
        function(){
			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				url: '<?php echo Router::url("/admin/question-answers/inactive-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						setTimeout(function () {
							swal({
								title: "Answer(s) successfully inactivated",
								type: "success",
								confirmButtonText: "OK",
								},
								function(){
									window.location.reload();
								});
						}, 500);						
					}else{
						swal("No answer(s) to mark as inactive", "", "warning");
					}
				}
			});
        });
}
function change_status(id,status){
	swal({
	  title: "Are you sure?",
	  type: "warning",
	  showCancelButton: true,
	  closeOnConfirm: false,
	  confirmButtonClass: 'btn-warning',
	  confirmButtonText: "Yes",
	  showLoaderOnConfirm: true
	}, function () {
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo Router::url("/admin/question-answers/change-status/",true); ?>',
			data: {id: id, status: status},
			success: function(result) {
				if(result.type == 'success'){
					setTimeout(function () {
						swal({
							title: result.message,
							type: result.type,
							confirmButtonText: "OK",
							},
							function(){
								window.location.reload();
							});
					}, 200);
				}else{
					setTimeout(function () {
						swal(result.message, "", result.type);
					}, 200);
				}
			}
		});
	});
}
</script>