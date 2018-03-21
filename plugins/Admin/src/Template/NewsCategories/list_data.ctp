<?php use Cake\Routing\Router; $session = $this->request->session(); ?>
<article class="content items-list-page">
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-9">
               <h3 class="title">
                  News Category<?php if(isset($this->request->params['pass'][0])): echo "&nbsp;Trash"; endif; ?>
				<?php if( (array_key_exists('add-news-category',$session->read('permissions.'.strtolower('NewsCategories')))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('add-news-category'))==1 ){?>
                  <a href="<?php echo Router::url('/admin/news-categories/add-news-category',true); ?>" class="btn btn-primary btn-sm rounded-s">
                  Add New
                  </a>
				<?php }else{ ?>
					<a></a>
				<?php } ?>
               </h3>
            </div>
         </div>
      </div>
      <div class="items-search">
         <form class="form-inline" action="<?php echo Router::url('/admin/news-categories/list-data',true); ?>" method="get">
            <div class="input-group">
               <span>
                  <input value="<?php if($this->request->query('search') !== NULL): echo $this->request->query('search'); endif; ?>" type="text" name="search" class="form-control boxed rounded-s" placeholder="Search by category name..." />
                </span>
                <span class="input-group-btn">
					<button class="btn btn-secondary rounded-s" type="submit" title="Search">
						<i class="fa fa-search"></i>
					</button>
					<a title="Reset" class="btn btn-secondary rounded-s" href="<?php echo Router::url('/admin/news-categories/list-data',true);?>">
						<i class="fa fa-refresh"></i>
					</a>
               </span>
            </div>
         </form>
      </div>
   </div>
   <div class="card items">
   <?php echo $this->Flash->render() ?>
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
               <div class="item-col fixed item-col-check">
               <?php if(!empty($news_categories_details)): ?>
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
                  <div> <span><?php echo $this->Paginator->sort('name', 'Name'); ?></span> </div>
                  
               </div>
				<div class="item-col item-col-header item-col-parent">
					<div> <span><a>Parent Category</a></span> </div>                  
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
         if(empty($news_categories_details)): ?>
            <li class="item">
				<div class="item-row">
				   <div>No results found</div>
				</div>
			 </li>
         <?php
         endif;
          foreach($news_categories_details as $news_category): ?>
			<li class="item table-data" id="row_id_<?php echo $news_category->id;?>">
			<div class="item-row">
			   <div class="item-col fixed item-col-check"> <label class="item-check">
				  <input type="checkbox" class="checkbox" value="<?php echo $news_category->id; ?>">
				  <span></span>
				  </label> 
			   </div>
			   <div class="item-col item-col-name">
				  <div class="item-heading">Name</div>
				  <div>  <?php echo $news_category->name; ?> </div>
			   </div>
			   <div class="item-col item-col-parent">
				  <div class="item-heading">Parent Category</div>
				  <div> <?php if($news_category['Parent']['name'] != '') echo $news_category['Parent']['name']; else echo 'N/A'; ?> </div>
			   </div>
			   <div class="item-col item-col-created">
				  <div class="item-heading">Added On</div>
				  <div> <?php echo date('jS F Y, H:i', strtotime($news_category->created));?></div>
			   </div>
			   <div class="item-col item-col-status">
				  <div class="item-heading">Status</div>
				  <div data-id="status<?php echo $news_category->id; ?>">  <?php if($news_category->status == 'I'): echo "<b>Inactive</b>"; else: echo "Active"; endif; ?> </div>
			   </div>
			   <div class="item-col fixed item-col-actions-dropdown">
				  <div class="item-actions-dropdown active">
					 <div class="item-actions-block options">
						<ul class="item-actions-list">
						<?php
						if( (array_key_exists('edit-news-category',$session->read('permissions.'.strtolower('NewsCategories')))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('edit-news-category'))==1 ){
						?>
						   <li>
							  <a class="edit" href="<?php echo Router::url("/admin/news-categories/edit-news-category",true).'/'.base64_encode($news_category->id); ?>" title="Edit"> 
								  <i class="fa fa-pencil"></i> 
							  </a>
						   </li>
						<?php
						}
						if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsCategories')))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('change-status'))==1 ){
						?>
							<li>
							<?php if($news_category->status == 'I'): ?>
								<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $news_category->id; ?>','A');" title="Click to Active">
									<i class="fa fa-lock" aria-hidden="true"></i>
								</a>
							<?php else: ?>
								<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $news_category->id; ?>','I');" title="Click to Inactive">
									<i class="fa fa-unlock" aria-hidden="true"></i>
								</a>
							<?php endif; ?>							 
						   </li>
						<?php
						}
						if( (array_key_exists('delete-news-category',$session->read('permissions.'.strtolower('NewsCategories')))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('delete-news-category'))==1 ){
						?>
						   <li>
						  <?php if(!isset($this->request->params['pass'][0]) & 0): 
								  $url = Router::url("/admin/news-categories/trash/",true);
							  else:
								  $url = Router::url("/admin/news-categories/delete/",true);
						   endif;
						   ?>
							  <a class="remove" href="javascript:void(0);" onclick="delete_news_category('<?php echo $news_category->id; ?>');" title="Delete">
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
	$form = ($this->request->params['paging']['NewsCategories']['page'] * $this->request->params['paging']['NewsCategories']['perPage']) - $this->request->params['paging']['NewsCategories']['perPage']+$cnt;
	$to = ($this->request->params['paging']['NewsCategories']['page'] * $this->request->params['paging']['NewsCategories']['perPage'])-$this->request->params['paging']['NewsCategories']['perPage'] + $this->request->params['paging']['NewsCategories']['current']; ?>

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
if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsCategories')))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('change-status'))==1) && ((array_key_exists('delete-news-category',$session->read('permissions.'.strtolower('NewsCategories')))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('delete-news-category'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete','activeAll','Active','inactiveAll','Inactive');
<?php
}else if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsCategories')))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('change-status'))==1) && ((!array_key_exists('delete-news-category',$session->read('permissions.'.strtolower('NewsCategories')))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('delete-news-category'))!=1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'activeAll','Active','inactiveAll','Inactive');
<?php
}
else if( ((!array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsCategories')))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('change-status'))!=1) && ((array_key_exists('delete-news-category',$session->read('permissions.'.strtolower('NewsCategories')))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('delete-news-category'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete');
<?php
}
?>

function delete_news_category(id){
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
			url: '<?php echo Router::url("/admin/news-categories/delete-news-category/",true); ?>',
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
				url: '<?php echo Router::url("/admin/news-categories/delete-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.delete_count == 1){	//all categories successfully deleted
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
					}else if(result.delete_count == 2){	//no categories deleted
						setTimeout(function () {
							swal({
								title: result.message,
								type: result.type,
								confirmButtonText: "Ok",
								},
								function(){									
								});
						}, 500);
					}else if(result.delete_count == 3){
						setTimeout(function () {	//some categories deleted
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
				url: '<?php echo Router::url("/admin/news-categories/active-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						setTimeout(function () {
							swal({
								title: "Categories successfully activated",
								type: "success",
								confirmButtonText: "Ok",
								},
								function(){
									window.location.reload();
								});
						}, 500);						
					}else{
						swal("No Categories to mark as active", "", "warning");
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
				url: '<?php echo Router::url("/admin/news-categories/inactive-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.delete_count == 1){	//all categories successfully inactivated
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
					}else if(result.delete_count == 2){	//no categories inactivated
						setTimeout(function () {
							swal({
								title: result.message,
								type: result.type,
								confirmButtonText: "Ok",
								},
								function(){									
								});
						}, 500);
					}else if(result.delete_count == 3){
						setTimeout(function () {	//some categories inactivated
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
			url: '<?php echo Router::url("/admin/news-categories/change-status/",true); ?>',
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
</script>