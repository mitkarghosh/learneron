<?php use Cake\Routing\Router; $session = $this->request->session();?>
<style>
.top-gap{margin-top:10px;}
</style>
<article class="content items-list-page">
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-9">
               <h3 class="title">
                  All News<?php if(isset($this->request->params['pass'][0])): echo "&nbsp;Trash"; endif; ?>
				<?php if( (array_key_exists('add-news',$session->read('permissions.'.strtolower('News')))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('add-news'))==1 ){?>
                  <a href="<?php echo Router::url('/admin/news/add-news',true); ?>" class="btn btn-primary btn-sm rounded-s">
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
         <form class="form-inline" action="<?php echo Router::url('/admin/news/list-data/',true); ?>" method="get">
            <div class="input-group">
               <span>
                  <input value="<?php if($this->request->query('search') !== NULL): echo $this->request->query('search'); endif; ?>" type="text" name="search" class="form-control boxed rounded-s" placeholder="Search by name..." />
                </span>
                <span>
                   <select class="form-control" name="search_by">
                     <option value="">Select Category</option>
				<?php
					if(!empty($all_category)){
						foreach($all_category as $key_ac => $val_ac){
				?>
							<option value="<?php echo $key_ac;?>"><?php echo $val_ac;?></option>
				<?php
						}
					}
				?>
                   </select>
                   <?php if($this->request->query('search') !== NULL): ?>
                              <script type="text/javascript">
                                $('select[name="search_by"]').val("<?php echo $this->request->query('search_by'); ?>");
                              </script>
                    <?php endif; ?>
               </span>
                <span class="input-group-btn">
                   <button class="btn btn-secondary rounded-s" type="submit" title="Search">
                        <i class="fa fa-search"></i>
                   </button>
				   <a title="Reset" class="btn btn-secondary rounded-s" href="<?php echo Router::url('/admin/news/list-data',true);?>">
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
               <?php if(!empty($newsDetails)): ?>
                  <label class="item-check" id="select-all-items">
                      <input type="checkbox" class="checkbox">
                      <span></span>
                  </label> 
                <?php endif; ?>
               </div>
               <div class="item-col item-col-header item-col-name">
                  <div> <span><a href="javascript:void(0);">Image</a></span> </div>
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
                  <div> <span><?php echo $this->Paginator->sort('name', 'News Title'); ?></span> </div>
                  
               </div>
			   <div class="item-col item-col-header item-col-category">
				<div> <span><a>Category</a></span> </div>                  
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
         if(empty($newsDetails)): ?>
            <li class="item">
				<div class="item-row">
				   <div>No results found</div>
				</div>
			 </li>
         <?php
         endif;
          foreach($newsDetails as $new_detail): ?>
                 <li class="item table-data" id="row_id_<?php echo $new_detail->id;?>">
                    <div class="item-row">
                       <div class="item-col fixed item-col-check"> <label class="item-check">
                          <input type="checkbox" class="checkbox" value="<?php echo $new_detail->id; ?>">
                          <span></span>
                          </label> 
                       </div>
                       <div class="item-col item-col-name">
                          <div class="item-heading">Image</div>
							<?php
							if($new_detail->image !=''){
								$image = $new_detail->image;
								$image = Router::url('/uploads/news/thumb/', true).$image;
							}else{
								$image = 'no-image.png';
								$image = Router::url('/images/', true).$image;
							}
							?>
                          <img src="<?php echo $image; ?>" width='100' height='60' />
                       </div>

                       <div class="item-col item-col-name">
                          <div class="item-heading">News Title</div>
                          <div><?php echo $new_detail->name;?></div>
                       </div>
					   <div class="item-col item-col-category">
                          <div class="item-heading">Category</div>
                          <div style='font-weight:normal;'><?php echo $new_detail->news_category->name; ?> </div>
                       </div>
                       <div class="item-col item-col-status">
                          <div class="item-heading">Status</div>
                          <div data-id="status<?php echo $new_detail->id; ?>">  <?php if($new_detail->status == 'I'): echo "<b>Inactive</b>"; else: echo "Active"; endif; ?> </div>
                       </div>
                       <div class="item-col item-col-created">
                          <div class="item-heading">Created</div>
                          <div class="no-overflow"> <?php echo date('jS F Y',strtotime($new_detail->created)); ?> </div>
                       </div>
                       <div class="item-col fixed item-col-actions-dropdown">
                          <div class="item-actions-dropdown active">
                             <div class="item-actions-block options">
                                <ul class="item-actions-list">
								<?php
								if( (array_key_exists('edit-news',$session->read('permissions.'.strtolower('News')))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('edit-news'))==1 ){
								?>
                                   <li>
                                      <a class="edit" href="<?php echo Router::url("/admin/news/edit-news",true).'/'.base64_encode($new_detail->id); ?>" title="Edit"> 
                                          <i class="fa fa-pencil"></i> 
                                      </a>
                                   </li>
								<?php
								}
								if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('News')))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('change-status'))==1 ){
								?>
								   <li>
									<?php if($new_detail->status == 'I'): ?>
										<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $new_detail->id; ?>','A');" title="Click to Active">
											<i class="fa fa-lock" aria-hidden="true"></i>
										</a>
									<?php else: ?>
										<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $new_detail->id; ?>','I');" title="Click to Inactive">
											<i class="fa fa-unlock" aria-hidden="true"></i>
										</a>
									<?php endif; ?>							 
								   </li><br />
								<?php
								}
								if( (array_key_exists('delete-news',$session->read('permissions.'.strtolower('News')))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('delete-news'))==1 ){
								?>
                                   <li class="top-gap">
									  <a class="remove" href="javascript:void(0);" onclick="delete_news('<?php echo $new_detail->id; ?>');" title="Delete">
										<i class="fa fa-trash-o "></i> 
									  </a>
                                   </li>
								<?php
								}
								if( (array_key_exists('list-data',$session->read('permissions.'.strtolower('NewsComments')))) && $session->read('permissions.'.strtolower('NewsComments').'.'.strtolower('list-data'))==1 ){
								?>
								   <li>
										<a class="info" href="<?php echo Router::url("/admin/news-comments/list-data",true).'?search=&search_by='.$new_detail->id;?>" title="Answers" style="width:20px;">
											<i class="fa fa-question-circle"></i> <?php if(count($new_detail->news_comments) != 0){echo '<span class="unapproved_newscomments"><span class="unapproved_newscomments_number">'.count($new_detail->news_comments).'</span></span>';}?>
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
   $form = ($this->request->params['paging']['News']['page'] * $this->request->params['paging']['News']['perPage']) - $this->request->params['paging']['News']['perPage']+$cnt; 
   $to = ($this->request->params['paging']['News']['page'] * $this->request->params['paging']['News']['perPage'])-$this->request->params['paging']['News']['perPage'] + $this->request->params['paging']['News']['current']; ?>

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
.unapproved_newscomments{background-color: #000; border-radius: 100% !important; color: #fff; height: auto !important; padding: 0px 5px !important; position: relative; right: 9px; text-align: center; top: -11px; vertical-align: top !important; width: auto !important; font-weight: normal;}
.unapproved_newscomments_blink{background-color: #caa961 !important;}
.unapproved_newscomments_number{font-size: 12px;}
</style>
<script type="text/javascript">
setInterval(function(){
	$('span.unapproved_newscomments').toggleClass('unapproved_newscomments_blink')
}, 800);

<?php
if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('News')))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('change-status'))==1) && ((array_key_exists('delete-news',$session->read('permissions.'.strtolower('News')))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('delete-news'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete','activeAll','Active','inactiveAll','Inactive');
<?php
}else if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('News')))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('change-status'))==1) && ((!array_key_exists('delete-news',$session->read('permissions.'.strtolower('News')))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('delete-news'))!=1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'activeAll','Active','inactiveAll','Inactive');
<?php
}
else if( ((!array_key_exists('change-status',$session->read('permissions.'.strtolower('News')))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('change-status'))!=1) && ((array_key_exists('delete-news',$session->read('permissions.'.strtolower('News')))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('delete-news'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete');
<?php
}
?>

function delete_news(id){
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
			url: '<?php echo Router::url("/admin/news/delete-news/",true); ?>',
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
				url: '<?php echo Router::url("/admin/news/delete-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.delete_count == 1){	//all news successfully deleted
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
				url: '<?php echo Router::url("/admin/news/active-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						setTimeout(function () {
							swal({
								title: "News successfully activated",
								type: "success",
								confirmButtonText: "Ok",
								},
								function(){
									window.location.reload();
								});
						}, 500);						
					}else{
						swal("No news to mark as active", "", "warning");
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
				url: '<?php echo Router::url("/admin/news/inactive-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.inactive_count == 1){	//all news successfully inactivated
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
			url: '<?php echo Router::url("/admin/news/change-status/",true); ?>',
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