<?php use Cake\Routing\Router; $session = $this->request->session();
$this->assign('hasDatepicker', true);?>
<style>
.align-center{text-align:center;}
.right-gap{margin-right:10px;}
.top-gap{margin-top:10px;}
</style>
<article class="content items-list-page">
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-9">
               <h3 class="title">
                  Questions<?php if(isset($this->request->params['pass'][0])): echo "&nbsp;Trash"; endif; ?>
				<?php if( (array_key_exists('add-question',$session->read('permissions.'.strtolower('Questions')))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('add-question'))==1 ){?>
                  <a href="<?php echo Router::url('/admin/questions/add-question',true); ?>" class="btn btn-primary btn-sm rounded-s">
                  Add New
                  </a>
				<?php }else{ ?>
					<a></a>
				<?php } ?>
               </h3>
            </div>
         </div>
		 
		 <div style="float:left;">
			<div class="clearfix">&nbsp;</div>
			<form class="form-inline" action="<?php echo Router::url('/admin/questions/list-data',true); ?>" method="get">
            <div class="input-group">
               <span>
                  <input value="<?php if($this->request->query('search') !== null): echo $this->request->query('search'); endif; ?>" type="text" name="search" class="form-control boxed rounded-s right-gap" placeholder="Search by question..." />
                </span>
				<span>
                   <select class="form-control right-gap" name="search_by" style="height:40px;">
                     <option value="">Select Category</option>
				<?php
					if(!empty($question_categories)){
						foreach($question_categories as $key_qc => $val_qc){
				?>
							<option value="<?php echo $key_qc;?>"><?php echo $val_qc;?></option>
				<?php
						}
					}
				?>
                   </select>
                   <?php if($this->request->query('search_by') !== NULL): ?>
                        <script type="text/javascript">
                            $('select[name="search_by"]').val("<?php echo $this->request->query('search_by'); ?>");
                        </script>
                    <?php endif; ?>
				</span>
				<span>
					<input value="<?php if($this->request->query('created') !== null): echo $this->request->query('created'); endif; ?>" type="text" id="created_date" name="created" data-provide="datepicker" class="form-control boxed rounded-s right-gap" placeholder="Search by date..." />
				</span>
				<span>
                   <select class="form-control right-gap" name="search_by_user" style="height:40px;">
                     <option value="">Select User</option>
				<?php
					if(!empty($get_all_submitted_user)){
						foreach($get_all_submitted_user as $key_user => $val_user){
				?>				
							<option value="<?php echo $val_user->id;?>"><?php echo $val_user->name;?></option>
				<?php
						}
					}
				?>
                   </select>
                   <?php if($this->request->query('search_by_user') !== NULL): ?>
                        <script type="text/javascript">
                            $('select[name="search_by_user"]').val("<?php echo $this->request->query('search_by_user'); ?>");
                        </script>
                    <?php endif; ?>
				</span>
				<span>
                   <select class="form-control right-gap" name="search_by_id" style="height:40px;">
                     <option value="">Select id</option>
				<?php
					if(!empty($get_all_questions_ids)){
						foreach($get_all_questions_ids as $key_id => $val_id){
				?>				
							<option value="<?php echo $key_id;?>"><?php echo $key_id;?></option>
				<?php
						}
					}
				?>
                   </select>
                   <?php if($this->request->query('search_by_id') !== NULL): ?>
                        <script type="text/javascript">
                            $('select[name="search_by_id"]').val("<?php echo $this->request->query('search_by_id'); ?>");
                        </script>
                    <?php endif; ?>
				</span>
			    <span class="input-group-btn">
                   <button class="btn btn-secondary rounded-s" type="submit" title="Search">
                        <i class="fa fa-search"></i>
                   </button>
				   <a title="Reset" class="btn btn-secondary rounded-s" href="<?php echo Router::url('/admin/questions/list-data',true);?>">
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
               <?php if(!empty($question_details)): ?>
                  <label class="item-check" id="select-all-items">
                      <input type="checkbox" class="checkbox">
                      <span></span>
                  </label> 
                <?php endif; ?>
               </div>
               <div class="item-col item-col-header item-col-name">
               <?php if($this->request->query('sort') == 'name' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'name' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('name', $sortOrder,['escape' => false]); ?>
                  <div> <span><?php echo $this->Paginator->sort('name', 'Question'); ?></span> </div>
                  
               </div>
				<div class="item-col item-col-header item-col-parent align-center">
					<div><span><a>Category</a></span></div>
				</div>
				<div class="item-col item-col-header item-col-featured align-center">
					<?php if($this->request->query('sort') == 'is_featured' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true" title="sort by featured"></i>';
                        elseif($this->request->query('sort') == 'is_featured' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true" title="sort by featured"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true" title="sort by featured"></i>';
                        endif;
                            echo $this->Paginator->sort('is_featured', $sortOrder,['escape' => false]); ?>
                  <div> <span title="sort by featured"><?php echo $this->Paginator->sort('is_featured', 'Featured'); ?></span> </div>
				</div>
				<div class="item-col item-col-header item-col-created align-center">
					<?php if($this->request->query('sort') == 'created' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true" title="sort by added on"></i>';
                        elseif($this->request->query('sort') == 'created' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true" title="sort by added on"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true" title="sort by added on"></i>';
                        endif;
                            echo $this->Paginator->sort('created', $sortOrder,['escape' => false]); ?>
					<div> <span title="sort by added on"><?php echo $this->Paginator->sort('created', 'Added On'); ?></span> </div>					
				</div>
               <div class="item-col item-col-header item-col-status align-center">
               <?php if($this->request->query('sort') == 'status' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true" title="sort by status"></i>';
                        elseif($this->request->query('sort') == 'status' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true" title="sort by status"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true" title="sort by status"></i>';
                        endif;
                            echo $this->Paginator->sort('status', $sortOrder,['escape' => false]); ?>
                  <div> <span title="sort by status"><?php echo $this->Paginator->sort('status', 'Status'); ?></span> </div>                  
               </div>               
               <div class="item-col item-col-header fixed item-col-actions-dropdown align-center"> <span><a>Action</a></span> </div>
            </div>
         </li>
         <?php
         if(empty($question_details)): ?>
            <li class="item">
				<div class="item-row">
				   <div>No results found</div>
				</div>
			 </li>
         <?php
         endif;
          foreach($question_details as $question): ?>
			<li class="item table-data" id="row_id_<?php echo $question->id;?>">
			<div class="item-row">
			   <div class="item-col fixed item-col-check"> <label class="item-check">
				  <input type="checkbox" class="checkbox" value="<?php echo $question->id; ?>">
				  <span></span>
				  </label> 
			   </div>
			   <div class="item-col item-col-name">
				  <div class="item-heading">Question</div>
				  <div><?php echo substr($question->name, 0, 100); if(strlen($question->name)>100){ echo '...'; } ?></div>
			   </div>
			   <div class="item-col item-col-parent align-center">
				  <div class="item-heading">Category</div>
				  <div><?php if($question->question_category->name != '') echo $question->question_category->name; else echo 'N/A'; ?> </div>
			   </div>
			   <div class="item-col item-col-featured align-center">
				  <div class="item-heading">Featured</div>
				  <div><?php if($question->is_featured == 'Y'): echo "Yes"; else: echo "No"; endif; ?> </div>
			   </div>
			   <div class="item-col item-col-created align-center">
				  <div class="item-heading">Added On</div>
				  <div><?php if($question->created != ''): echo date('jS F Y', strtotime($question->created)); else: echo "N/A"; endif; ?> </div>
			   </div>
			   <div class="item-col item-col-status align-center">
				  <div class="item-heading">Status</div>
				  <div data-id="status<?php echo $question->id; ?>">  <?php if($question->status == 'I'): echo "<b>Inactive</b>"; else: echo "Active"; endif; ?> </div>
			   </div>
			   <div class="item-col fixed item-col-actions-dropdown align-center">
				  <div class="item-actions-dropdown active">
					 <div class="item-actions-block options">
						<ul class="item-actions-list">
						<?php
						if( (array_key_exists('edit-question',$session->read('permissions.'.strtolower('Questions')))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('edit-question'))==1 ){
						?>
						   <li>
							  <a class="edit" href="<?php echo Router::url("/admin/questions/edit-question",true).'/'.base64_encode($question->id); ?>" title="Edit"> 
								  <i class="fa fa-pencil"></i> 
							  </a>
						   </li>
						<?php
						}
						if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('Questions')))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('change-status'))==1 ){
						?>
						   <li>
							<?php if($question->status == 'I'): ?>
								<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $question->id; ?>','A');" title="Click to Active">
									<i class="fa fa-lock" aria-hidden="true"></i>
								</a>
							<?php else: ?>
								<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $question->id; ?>','I');" title="Click to Inactive">
									<i class="fa fa-unlock" aria-hidden="true"></i>
								</a>
							<?php endif; ?>							 
						   </li>
						<?php
						}
						if( (array_key_exists('delete-question',$session->read('permissions.'.strtolower('Questions')))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('delete-question'))==1 ){
						?>
						   <li>
								<a class="remove" href="javascript:void(0);" onclick="delete_question('<?php echo $question->id; ?>');" title="Delete">
									<i class="fa fa-trash-o"></i>
								</a>
						   </li><br />
						<?php
						}
						if( (array_key_exists('list-data',$session->read('permissions.'.strtolower('QuestionAnswers')))) && $session->read('permissions.'.strtolower('QuestionAnswers').'.'.strtolower('list-data'))==1 ){
						?>
						   <li class="top-gap">
								<a class="info" href="<?php echo Router::url("/admin/question-answers/list-data",true).'?search=&search_by='.$question->name;?>" title="Answers">
									<i class="fa fa-question-circle"></i> <?php if(count($question->question_answers) != 0){echo '<span class="unapproved_answers"><span class="unapproved_answers_number">'.count($question->question_answers).'</span></span>';}?>
								</a>
						   </li>
						<?php
						}
						if( (array_key_exists('list-data',$session->read('permissions.'.strtolower('QuestionComments')))) && $session->read('permissions.'.strtolower('QuestionComments').'.'.strtolower('list-data'))==1 ){
						?>
						   <li>
								<a class="info" href="<?php echo Router::url("/admin/question-comments/list-data",true).'?search=&search_by_id='.$question->id;?>" title="Comments">
									<i class="fa fa-comments-o"></i> <?php if(count($question->question_comments) != 0){echo '<span class="unapproved_comments"><span class="unapproved_comments_number">'.count($question->question_comments).'</span></span>';}?>
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
	$form = ($this->request->params['paging']['Questions']['page'] * $this->request->params['paging']['Questions']['perPage']) - $this->request->params['paging']['Questions']['perPage']+$cnt;
	$to = ($this->request->params['paging']['Questions']['page'] * $this->request->params['paging']['Questions']['perPage'])-$this->request->params['paging']['Questions']['perPage'] + $this->request->params['paging']['Questions']['current']; ?>

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
.unapproved_answers{background-color: #000; border-radius: 100% !important; color: #fff; height: auto !important; padding: 0px 5px !important; position: relative; right: 9px; text-align: center; top: -11px; vertical-align: top !important; width: auto !important; font-weight: normal;}
.unapproved_answers_blink{background-color: #caa961 !important;}
.unapproved_answers_number{font-size: 12px;}
.unapproved_comments{background-color: #000; border-radius: 100% !important; color: #fff; height: auto !important; padding: 0px 5px !important; position: relative; right: 11px; text-align: center; top: -11px; vertical-align: top !important; width: auto !important; font-weight: normal;}
.unapproved_comments_blink{background-color: #caa961 !important;}
.unapproved_comments_number{font-size: 12px;}
.item-actions-list > li{width:20px;}
</style>
<script type="text/javascript">
setInterval(function(){
	$('span.unapproved_answers').toggleClass('unapproved_answers_blink')
}, 800);
setInterval(function(){
	$('span.unapproved_comments').toggleClass('unapproved_comments_blink')
}, 800);

<?php
if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('Questions')))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('change-status'))==1) && ((array_key_exists('delete-question',$session->read('permissions.'.strtolower('Questions')))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('delete-question'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete','activeAll','Active','inactiveAll','Inactive');
<?php
}else if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('Questions')))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('change-status'))==1) && ((!array_key_exists('delete-question',$session->read('permissions.'.strtolower('Questions')))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('delete-question'))!=1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'activeAll','Active','inactiveAll','Inactive');
<?php
}
else if( ((!array_key_exists('change-status',$session->read('permissions.'.strtolower('Questions')))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('change-status'))!=1) && ((array_key_exists('delete-question',$session->read('permissions.'.strtolower('Questions')))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('delete-question'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete');
<?php
}
?>

function delete_question(id){
	swal({
	  title: "Are you sure? related answers, comments and others will be deleted",
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
			url: '<?php echo Router::url("/admin/questions/delete-question/",true); ?>',
			data: {id: id},			
			success: function(result) {
				if(result.type == 'success'){
					setTimeout(function () {
						$('#row_id_'+result.deleted_id).remove();
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
						swal(result.message, "", "error");
					}, 200);
				}
			}
		});
	});
}
function deleteAll(){
	swal({
          title: "Are you sure? related answers, comments and others will be deleted",
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
				url: '<?php echo Router::url("/admin/questions/delete-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.delete_count == 1){	//all categories successfully deleted
						setTimeout(function () {
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
								confirmButtonText: "OK",
								},
								function(){
									window.location.reload();
								});
						}, 500);
					}else if(result.delete_count == 3){	//some categories deleted
						if(result.deleted_ids.length == 1){
							$('#row_id_'+result.deleted_ids).remove();
						}else{
							var data = result.deleted_ids;
							$.each(data, function(index,value){
								$('#row_id_'+value).remove();
							});
						}
						setTimeout(function () {
							swal({
								title: result.message,
								type: result.type,
								confirmButtonText: "OK",
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
				url: '<?php echo Router::url("/admin/questions/active-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						setTimeout(function () {
							swal({
								title: "Question(s) successfully activated",
								type: "success",
								confirmButtonText: "OK",
								},
								function(){
									window.location.reload();
								});
						}, 500);						
					}else{
						swal("No question(s) to mark as active", "", "warning");
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
				url: '<?php echo Router::url("/admin/questions/inactive-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						setTimeout(function () {
							swal({
								title: "Question(s) successfully inactivated",
								type: "success",
								confirmButtonText: "OK",
								},
								function(){
									window.location.reload();
								});
						}, 500);						
					}else{
						swal("No question(s) to mark as inactive", "", "warning");
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
			url: '<?php echo Router::url("/admin/questions/change-status/",true); ?>',
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

$(document).ready(function(){
	var created_date = $( "#created_date" ).datepicker({'maxDate': 0}).on('change', function(){});	
});
</script>