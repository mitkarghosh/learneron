<?php
use Cake\Routing\Router; $session = $this->request->session();
$this->assign('hasDatepicker', true);
?>
<style>
.right-gap{margin-right:10px;}
</style>
<article class="content items-list-page">
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-9">
               <h3 class="title">
                  All News Comments<?php if(isset($this->request->params['pass'][0])): echo "&nbsp;Trash"; endif; ?>
                  <a></a>
               </h3>
            </div>
         </div>
		 <div style="float:left;">
			<div class="clearfix">&nbsp;</div>
			<form class="form-inline" action="<?php echo Router::url('/admin/news-comments/list-data/',true); ?>" method="get">
            <div class="input-group">
               <span>
                  <input value="<?php if($this->request->query('search') !== NULL): echo $this->request->query('search'); endif; ?>" type="text" name="search" class="form-control boxed rounded-s right-gap" placeholder="Search by comment..." style="width:200px;" />
                </span>
                <span>
                   <select class="form-control right-gap" name="search_by" style="height:39px;">
                     <option value="">Select News</option>
				<?php
					if(!empty($all_news)){
						foreach($all_news as $key_an => $val_an){
				?>
							<option value="<?php echo $key_an;?>"><?php echo substr($val_an,0,30); if(strlen($val_an)>30)echo '...';?></option>
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
                   <select class="form-control right-gap" name="search_by_commentuser" style="height:39px;">
                     <option value="">Select User</option>
				<?php
					if(!empty($news_comment_users)){
						foreach($news_comment_users as $key_ncu => $val_ncu){
				?>
							<option value="<?php echo $key_ncu;?>"><?php echo $val_ncu;?></option>
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
                <span class="input-group-btn">
                   <button class="btn btn-secondary rounded-s" type="submit" title="Search">
                        <i class="fa fa-search"></i>
                   </button>
				   <a title="Reset" class="btn btn-secondary rounded-s" href="<?php echo Router::url('/admin/news-comments/list-data',true);?>">
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
               <?php if(!empty($newsCommentDetails)): ?>
                  <label class="item-check" id="select-all-items">
                      <input type="checkbox" class="checkbox">
                      <span></span>
                  </label> 
                <?php endif; ?>
               </div>
               <div class="item-col item-col-header item-col-name">
               <?php if($this->request->query('sort') == 'comment' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'comment' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('comment', $sortOrder,['escape' => false]); ?>
                  <div> <span><?php echo $this->Paginator->sort('comment', 'Comment'); ?></span> </div>
                  
               </div>
			   <div class="item-col item-col-header item-col-category">
				<div><span><a>News</a></span> </div>                  
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

               <div class="item-col item-col-header item-col-created">
               <?php if($this->request->query('sort') == 'created' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'created' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('created', $sortOrder,['escape' => false]); ?>
                  <div> <span><?php echo $this->Paginator->sort('created', 'Created'); ?></span> </div>
               </div>
               <div class="item-col item-col-header fixed item-col-actions-dropdown"> <span><a>Action</a></span> </div>
            </div>
         </li>
         <?php
         if(empty($newsCommentDetails)): ?>
            <li class="item">
                    <div class="item-row">
                       <div>No results found</div>
                    </div>
                 </li>
         <?php
         endif;
          foreach($newsCommentDetails as $detail): ?>
                 <li class="item table-data" id="row_id_<?php echo $detail->id;?>">
                    <div class="item-row">
                       <div class="item-col fixed item-col-check"> <label class="item-check">
                          <input type="checkbox" class="checkbox" value="<?php echo $detail->id; ?>">
                          <span></span>
                          </label> 
                       </div>
                       
                       <div class="item-col item-col-name">
                          <div class="item-heading">Comment</div>
                          <div><?php echo substr($detail->comment,0,60); if(strlen($detail->comment)>50)echo '...';?></div>
                       </div>
					   <div class="item-col item-col-category">
                          <div class="item-heading">News Title</div>
                          <div style='font-weight:normal;'><?php echo $detail->news->name;?></div>
                       </div>
                       <div class="item-col item-col-status">
                          <div class="item-heading">Status</div>
                          <div data-id="status<?php echo $detail->id; ?>"> <?php if($detail['status'] == 0)echo "<b>Inactive</b>"; else echo "Active"; ?> </div>
                       </div>
                       <div class="item-col item-col-created">
                          <div class="item-heading">Created</div>
                          <div class="no-overflow"> <?php echo date('jS F Y',strtotime($detail->created)); ?> </div>
                       </div>
                       <div class="item-col fixed item-col-actions-dropdown">
                          <div class="item-actions-dropdown active">
                             <div class="item-actions-block options">
                                <ul class="item-actions-list">
								<?php
								if( (array_key_exists('edit-comment',$session->read('permissions.'.strtolower('NewsComments')))) && $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('edit-comment'))==1 ){
								?>
                                   <li>
                                      <a class="edit" href="<?php echo Router::url("/admin/news-comments/edit-comment",true).'/'.base64_encode($detail->id); ?>" title="Edit"> 
                                          <i class="fa fa-pencil"></i> 
                                      </a>
                                   </li>
								<?php
								}
								if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsComments')))) && $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('change-status'))==1 ){
								?>
								   <li>
									<?php if($detail->status == 0): ?>
										<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $detail->id; ?>',1);" title="Click to Active">
											<i class="fa fa-lock" aria-hidden="true"></i>
										</a>
									<?php else: ?>
										<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $detail->id; ?>',0);" title="Click to Inactive">
											<i class="fa fa-unlock" aria-hidden="true"></i>
										</a>
									<?php endif; ?>							 
								   </li>
								<?php
								}
								if( (array_key_exists('delete-comment',$session->read('permissions.'.strtolower('NewsComments')))) && $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('delete-comment'))==1 ){
								?>
                                   <li>
									  <a class="remove" href="javascript:void(0);" onclick="delete_comment('<?php echo $detail->id; ?>');" title="Delete">
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
   $form = ($this->request->params['paging']['NewsComments']['page'] * $this->request->params['paging']['NewsComments']['perPage']) - $this->request->params['paging']['NewsComments']['perPage']+$cnt; 
   $to = ($this->request->params['paging']['NewsComments']['page'] * $this->request->params['paging']['NewsComments']['perPage'])-$this->request->params['paging']['NewsComments']['perPage'] + $this->request->params['paging']['NewsComments']['current']; ?>

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
<?php
if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsComments')))) && $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('change-status'))==1) && ((array_key_exists('delete-comment',$session->read('permissions.'.strtolower('NewsComments')))) && $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('delete-comment'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete','activeAll','Active','inactiveAll','Inactive');
<?php
}else if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsComments')))) && $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('change-status'))==1) && ((!array_key_exists('delete-comment',$session->read('permissions.'.strtolower('NewsComments')))) && $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('delete-comment'))!=1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'activeAll','Active','inactiveAll','Inactive');
<?php
}
else if( ((!array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsComments')))) && $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('change-status'))!=1) && ((array_key_exists('delete-comment',$session->read('permissions.'.strtolower('NewsComments')))) && $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('delete-comment'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete');
<?php
}
?>

function delete_comment(id){
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
			url: '<?php echo Router::url("/admin/news-comments/delete-comment/",true); ?>',
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
						swal(result.message, "", result.type);
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
				url: '<?php echo Router::url("/admin/news-comments/delete-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.delete_count == 1){	//all comments successfully deleted
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
				url: '<?php echo Router::url("/admin/news-comments/active-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						setTimeout(function () {
							swal({
								title: "Comments successfully activated",
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
				url: '<?php echo Router::url("/admin/news-comments/inactive-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.inactive_count == 1){	//all comments successfully inactivated
						setTimeout(function () {
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
			url: '<?php echo Router::url("/admin/news-comments/change-status/",true); ?>',
			data: {id: id, status: status},
			success: function(result) {
				if(result.type == 'success'){
					setTimeout(function () {
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