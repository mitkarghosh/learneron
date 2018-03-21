<?php use Cake\Routing\Router;
$this->assign('hasDatepicker', true); ?>
<style type="text/css">
.sub-table{width: 100%;}
#ui-datepicker-div{top:160px;}
.search-by ul{list-style: outside none none; padding: 0;}
.search-by ul li{display: inline-block; margin-bottom: 10px;margin-right: 7px;}
.search-by ul li::after {color: #caa961; content: "|"; margin: 0 0 0 9px;}
</style>
<article class="content items-list-page">
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-8">
               <h3 class="title">
                  List Sub Admins<?php if(isset($this->request->params['pass'][0])): echo "&nbsp;Trash"; endif; ?>
				<?php if( (array_key_exists('add-sub-admin',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('add-sub-admin'))==1 ){?>
                  <a href="<?php echo Router::url('/admin/admin-details/add-sub-admin',true); ?>" class="btn btn-primary btn-sm rounded-s">
                  Add New
                  </a>
				<?php }else{ ?>
					<a></a>
				<?php } ?>
               </h3>
            </div>
         </div>
		
		<div class="search-by">
		<?php
		$element = '';
		if(!empty($alphabets_only)){
		?>
			<ul>
		<?php
			foreach($alphabets_only as $key_ao => $val_ao){
		?>
				<li><a href="<?php echo Router::url(array('controller'=>'AdminDetails','action'=>'list-sub-admin/')).'?search='.strtolower($key_ao);?>" <?php if(strtoupper($key_ao)==$element)echo 'style="color:#caa961"';?>><?php echo strtolower($key_ao);?></a></li>
		<?php
			}
		?>
				<li><a href="<?php echo Router::url(array('controller'=>'AdminDetails','action'=>'/'));?>">All</a></li>
			</ul>           	   	
		<?php
		}
		?>
		</div>
		 
      </div>
      <div class="items-search">
         <form class="form-inline" action="<?php echo Router::url('/admin/admin-details/list-sub-admin/',true); ?>" method="get">
            <div class="input-group">
               <span>
                  <input value="<?php if($this->request->query('search') !== NULL): echo $this->request->query('search'); endif; ?>" type="text" name="search" class="form-control boxed rounded-s" placeholder="Search by name..." />
                </span>
                <span class="input-group-btn">
                   <button class="btn btn-secondary rounded-s" type="submit" title="Search">
                        <i class="fa fa-search"></i>
                   </button>
				   <a title="reset" class="btn btn-secondary rounded-s" href="<?php echo Router::url('/admin/admin-details/list-sub-admin',true);?>">
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
               <?php if(!$userDetails->isEmpty()): ?>
                  <label class="item-check" id="select-all-items">
                      <input type="checkbox" class="checkbox" value="1">
                      <span></span>
                  </label> 
                <?php endif; ?>
               </div>
			   <div class="item-col item-col-header item-col-name">
               <?php if($this->request->query('sort') == 'first_name' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'first_name' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('first_name', $sortOrder,['escape' => false]); ?>
                  <div> <span><?php echo $this->Paginator->sort('first_name', 'First Name'); ?></span> </div>                  
               </div>
			   <div class="item-col item-col-header item-col-fullname">
               <?php if($this->request->query('sort') == 'last_name' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'last_name' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('last_name', $sortOrder,['escape' => false]); ?>
                  <div> <span><?php echo $this->Paginator->sort('last_name', 'Last Name'); ?></span> </div>                  
               </div>
			   <div class="item-col item-col-header item-col-email">
               <?php if($this->request->query('sort') == 'email' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'email' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('email', $sortOrder,['escape' => false]); ?>
                  <div> <span><?php echo $this->Paginator->sort('email', 'Email'); ?></span> </div>
                  
               </div>
			   <div class="item-col item-col-header item-col-added">
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
         if(empty($userDetails)): ?>
            <li class="item">
				<div class="item-row">
				   <div>No results found</div>
				</div>
			 </li>
         <?php
         endif;
          foreach($userDetails as $userDetail): ?>
			<li class="item table-data" id="row_id_<?php echo $userDetail->id;?>">
			<div class="item-row">
			   <div class="item-col fixed item-col-check"> <label class="item-check">
				  <input type="checkbox" class="checkbox" value="<?php echo $userDetail->id; ?>">
				  <span></span>
				  </label> 
			   </div>
			   <div class="item-col item-col-name">
				  <div class="item-heading">First Name</div>
				  <div>  <?php echo $userDetail->first_name; ?> </div>
			   </div>
			   <div class="item-col item-col-name">
				  <div class="item-heading">Last Name</div>
				  <div>  <?php echo $userDetail->last_name; ?> </div>
			   </div>
			   <div class="item-col item-col-name">
				  <div class="item-heading">Email</div>
				  <div>  <?php echo $userDetail->email; ?> </div>
			   </div>
			   <div class="item-col item-col-added">
				  <div class="item-heading">Created</div>
				  <div> <?php echo date('dS M Y',strtotime($userDetail->created)); ?> </div>
			   </div>
			   <div class="item-col item-col-status">
				  <div class="item-heading">Status</div>
				  <div data-id="status<?php echo $userDetail->id; ?>">  <?php if($userDetail->status == 'I'): echo "<b>Inactive</b>"; else: echo "Active"; endif; ?> </div>
			   </div>
			   <div class="item-col fixed item-col-actions-dropdown">
				  <div class="item-actions-dropdown active">
					 <div class="item-actions-block options">
						<ul class="item-actions-list">
						<?php
						if( (array_key_exists('edit-sub-admin',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('edit-sub-admin'))==1 ){
						?>
							<li>
							  <a class="edit" href="<?php echo Router::url("/admin/admin-details/edit-sub-admin",true).'/'.base64_encode($userDetail->id); ?>" title="Edit"> 
								  <i class="fa fa-pencil"></i> 
							  </a>
							</li>
						<?php
						}
						if( (array_key_exists('change-status-subadmin',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('change-status-subadmin'))==1 ){
						?>
							<li>
							<?php if($userDetail->status == 'I'): ?>
								<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $userDetail->id; ?>','A');" title="Click to Active">
									<i class="fa fa-lock" aria-hidden="true"></i>
								</a>
							<?php else: ?>
								<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $userDetail->id; ?>','I');" title="Click to Inactive">
									<i class="fa fa-unlock" aria-hidden="true"></i>
								</a>
							<?php endif; ?>							 
						   </li><br />
						<?php
						}
						if( (array_key_exists('delete-sub-admin',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('delete-sub-admin'))==1 ){
						?>
						   <li>
						    <a class="remove" href="javascript:void(0);" onclick="delete_user('<?php echo $userDetail->id; ?>');" title="Delete">
								<i class="fa fa-trash-o "></i> 
							  </a>
						   </li>
						<?php
						}
						if( (array_key_exists('sub-admin-change-password',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('sub-admin-change-password'))==1 ){
						?>
							<li>
								<a class="edit" href="<?php echo Router::url("/admin/admin-details/change-password-subadmin",true).'/'.base64_encode($userDetail->id);?>" title="Change Password">
								  <i class="fa fa-key"></i> 
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
	$form = ($this->request->params['paging']['Admins']['page'] * $this->request->params['paging']['Admins']['perPage']) - $this->request->params['paging']['Admins']['perPage']+$cnt;
	$to = ($this->request->params['paging']['Admins']['page'] * $this->request->params['paging']['Admins']['perPage'])-$this->request->params['paging']['Admins']['perPage'] + $this->request->params['paging']['Admins']['current']; ?>

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
if( ((array_key_exists('change-status-subadmin',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('change-status-subadmin'))==1) && ((array_key_exists('delete-sub-admin',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('delete-sub-admin'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete','activeAll','Active','inactiveAll','Inactive');
<?php
}else if( ((array_key_exists('change-status-subadmin',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('change-status-subadmin'))==1) && ((!array_key_exists('delete-sub-admin',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('delete-sub-admin'))!=1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'activeAll','Active','inactiveAll','Inactive');
<?php
}
else if( ((!array_key_exists('change-status-subadmin',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('change-status-subadmin'))!=1) && ((array_key_exists('delete-sub-admin',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('delete-sub-admin'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete');
<?php
}
?>
function delete_user(id){
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
			url: '<?php echo Router::url("/admin/admin-details/delete-user-subadmin/",true); ?>',
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
				url: '<?php echo Router::url("/admin/admin-details/delete-multiple-subadmin/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.delete_count == 1){	//all users successfully deleted
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
								confirmButtonText: "OK",
								},
								function(){
									window.location.reload();
								});
						}, 500);
					}else if(result.delete_count == 2){	//no users deleted
						setTimeout(function () {
							swal({
								title: result.message,
								type: result.type,
								confirmButtonText: "OK",
								},
								function(){									
								});
						}, 500);
					}else if(result.delete_count == 3){
						setTimeout(function () {	//some users deleted
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
				url: '<?php echo Router::url("/admin/admin-details/active-multiple-subadmin/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						if(result == 'permission error'){
							setTimeout(function () {
								swal("You don't have permission to access this page", "", "error");
							}, 200);
						}else{
							setTimeout(function () {
								swal({
									title: "Sub admin(s) successfully activated",
									type: "success",
									confirmButtonText: "OK",
									},
									function(){
										window.location.reload();
									});
							}, 500);
						}
					}else{
						swal("No sub admin(s) to mark as active", "", "warning");
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
				url: '<?php echo Router::url("/admin/admin-details/inactive-multiple-subadmin/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.delete_count == 1){	//all sub admins successfully inactivated
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
					}else if(result.delete_count == 2){	//no sub admin inactivated
						setTimeout(function () {
							swal({
								title: result.message,
								type: result.type,
								confirmButtonText: "OK",
								},
								function(){									
								});
						}, 500);
					}else if(result.delete_count == 3){
						setTimeout(function () {	//some sub admins inactivated
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
			url: '<?php echo Router::url("/admin/admin-details/change-status-subadmin/",true); ?>',
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