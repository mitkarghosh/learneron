<?php use Cake\Routing\Router; $session = $this->request->session(); ?>
<style>
.right-gap{margin-right:10px;}
</style>
<article class="content items-list-page">
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-9">
               <h3 class="title">
                  Comments
				  <a>&nbsp;</a>
               </h3>
            </div>
         </div>
		 <div style="float:left;">
			<div class="clearfix">&nbsp;</div>
			<form class="form-inline" action="<?php echo Router::url('/admin/answer-comments/list-data/'.base64_encode($answer_id),true); ?>" method="get">
            <div class="input-group">
               <span>
                  <input value="<?php if($this->request->query('search') !== null): echo $this->request->query('search'); endif; ?>" type="text" name="search" class="form-control boxed rounded-s right-gap" placeholder="Search by comment..." />
                </span>
				<span>
                   <select class="form-control right-gap" name="search_by_commentuser" style="height:40px;">
                     <option value="">Select Comment User</option>
				<?php
					if(!empty($comment_users)){
						foreach($comment_users as $key_user => $val_user){
				?>
							<option value="<?php echo $val_user['id'];?>"><?php echo $val_user['name'];?></option>
				<?php
						}
					}
				?>
                   </select>
                   <?php if($this->request->query('search_by_commentuser') !== NULL): ?>
                        <script type="text/javascript">
                            $('select[name="search_by_commentuser"]').val("<?php echo $this->request->query('search_by_commentuser'); ?>");
                        </script>
                    <?php endif; ?>
				</span>
				<span>
                   <select class="form-control right-gap" name="search_by_id" style="height:40px;">
                     <option value="">Select id</option>
				<?php
					if(!empty($all_com_ids)){
						foreach($all_com_ids as $val_user){
				?>
							<option value="<?php echo $val_user;?>"><?php echo $val_user;?></option>
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
				   <a title="Reset" class="btn btn-secondary rounded-s" href="<?php echo Router::url('/admin/answer-comments/list-data/'.base64_encode($answer_id),true);?>">
						<i class="fa fa-refresh"></i>
					</a>
               </span>
            </div>
         </form>
		 </div>
      </div>
      <div class="items-search">
      </div>
   </div>
   <div class="card items">
   <?php echo $this->Flash->render() ?>
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
               <div class="item-col fixed item-col-check">
               <?php if(!empty($comment_details)): ?>
                  <label class="item-check" id="select-all-items">
                      <input type="checkbox" class="checkbox">
                      <span></span>
                  </label> 
                <?php endif; ?>
               </div>
               <div class="item-col item-col-header item-col-name">               
                  <div> <span><a>Comment</a></span></div>
               </div>
				<div class="item-col item-col-header item-col-parent">
					<div> <span><a>User</a></span></div>
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
         if(empty($comment_details)): ?>
            <li class="item">
				<div class="item-row">
				   <div>No results found</div>
				</div>
			 </li>
         <?php
         endif;
          foreach($comment_details as $comment): ?>
			<li class="item table-data" id="row_id_<?php echo $comment->id;?>">
			<div class="item-row">
			   <div class="item-col fixed item-col-check"> <label class="item-check">
				  <input type="checkbox" class="checkbox" value="<?php echo $comment->id; ?>">
				  <span></span>
				  </label> 
			   </div>
			   <div class="item-col item-col-name">
				  <div class="item-heading">Answer</div>
				  <div><?php echo substr($comment->comment, 0, 200); if(strlen($comment->comment)>200){ echo '...'; } ?></div>
			   </div>
			   <div class="item-col item-col-parent">
				  <div class="item-heading">User</div>
				  <div><?php if($comment->comment_user->name != '') echo $comment->comment_user->name; else echo 'N/A';?></div>
			   </div>
			   <div class="item-col item-col-featured">
				  <div class="item-heading">Added On</div>
				  <div><?php if($comment->created != ''): echo date('jS F Y', strtotime($comment->created)); else: echo "N/A"; endif; ?> </div>
			   </div>
			   <div class="item-col item-col-status">
				  <div class="item-heading">Status</div>
				  <div data-id="status<?php echo $comment->id; ?>">  <?php if($comment->status == 0): echo "<b>Inactive</b>"; else: echo "Active"; endif; ?> </div>
			   </div>
			   <div class="item-col fixed item-col-actions-dropdown">
				  <div class="item-actions-dropdown active">
					 <div class="item-actions-block options">
						<ul class="item-actions-list">
						<?php
						if( (array_key_exists('edit-answer-comment',$session->read('permissions.'.strtolower('AnswerComments')))) && $session->read('permissions.'.strtolower('AnswerComments').'.'.strtolower('edit-answer-comment'))==1 ){
						?>
							<li>
							  <a class="edit" href="<?php echo Router::url("/admin/answer-comments/edit-answer-comment",true).'/'.base64_encode($comment->id).'/'.base64_encode($answer_id); ?>" title="Edit"> 
								  <i class="fa fa-pencil"></i> 
							  </a>
						   </li>
						<?php
						}
						if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('AnswerComments')))) && $session->read('permissions.'.strtolower('AnswerComments').'.'.strtolower('change-status'))==1 ){
						?>
						   <li>
							<?php if($comment->status == 0): ?>
								<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $comment->id; ?>',1);" title="Click to Active">
									<i class="fa fa-lock" aria-hidden="true"></i>
								</a>
							<?php else: ?>
								<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $comment->id; ?>',0);" title="Click to Inactive">
									<i class="fa fa-unlock" aria-hidden="true"></i>
								</a>
							<?php endif; ?>							 
						   </li>
						   <li>
								<a class="remove" href="javascript:void(0);" onclick="delete_question('<?php echo $comment->id; ?>');" title="Delete">
								<i class="fa fa-trash-o "></i> 
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
	$form = ($this->request->params['paging']['AnswerComment']['page'] * $this->request->params['paging']['AnswerComment']['perPage']) - $this->request->params['paging']['AnswerComment']['perPage']+$cnt;
	$to = ($this->request->params['paging']['AnswerComment']['page'] * $this->request->params['paging']['AnswerComment']['perPage'])-$this->request->params['paging']['AnswerComment']['perPage'] + $this->request->params['paging']['AnswerComment']['current']; ?>

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
<script type="text/javascript">
var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll', 'Delete', 'activeAll', 'Active', 'inactiveAll', 'Inactive');

function delete_question(id){
	swal({
	  title: "Are you sure?",
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
			url: '<?php echo Router::url("/admin/answer-comments/delete-comment/",true); ?>',
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
				url: '<?php echo Router::url("/admin/answer-comments/delete-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.delete_count == 1){	//all comments successfully deleted
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
				url: '<?php echo Router::url("/admin/answer-comments/active-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						setTimeout(function () {
							swal({
								title: "Comment(s) successfully activated",
								type: "success",
								confirmButtonText: "Ok",
								},
								function(){
									window.location.reload();
								});
						}, 500);						
					}else{
						swal("No comment(s) to mark as active", "", "warning");
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
				url: '<?php echo Router::url("/admin/answer-comments/inactive-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						setTimeout(function () {
							swal({
								title: "Comment(s) successfully inactivated",
								type: "success",
								confirmButtonText: "OK",
								},
								function(){
									window.location.reload();
								});
						}, 500);						
					}else{
						swal("No comment(s) to mark as inactive", "", "warning");
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
			url: '<?php echo Router::url("/admin/answer-comments/change-status/",true); ?>',
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