<?php use Cake\Routing\Router; $session = $this->request->session();?>
<article class="content items-list-page">
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-7">
               <h3 class="title">
                  Details
					<a></a>
               </h3>
            </div>
         </div>
      </div>
      <!--<div class="items-search">
         <form class="form-inline" action="<?php echo Router::url('/admin/bannerSections/list-data/',true); ?>" method="get">
            <div class="input-group">
               <span>
                  <input value="<?php if($this->request->query('search') !== null): echo $this->request->query('search'); endif; ?>" type="text" name="search" class="form-control boxed rounded-s" placeholder="Search by banner title..." />
                </span>
                <span class="input-group-btn">
                   <button class="btn btn-secondary rounded-s" type="submit">
                        <i class="fa fa-search"></i>
                   </button>
				   <a title="reset" class="btn btn-secondary rounded-s" href="<?php echo Router::url('/admin/banner-sections/list-data',true);?>">
						<i class="fa fa-refresh"></i>
					</a>
               </span>
            </div>
         </form>
      </div>-->
   </div>
   <div class="card items">
   <?php echo $this->Flash->render() ?>
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
				<div class="item-col fixed item-col-check">
				<?php if(!$cookieSectionDetails->isEmpty()): ?>
                  <label class="item-check" id="select-all-items">
                      <input type="checkbox" class="checkbox">
                      <span></span>
                  </label> 
                <?php endif; ?>
				</div>
				<div class="item-col item-col-header item-col-name">
					<div> <span><a href="javascript:void(0);">IP Address</a></span> </div>
				</div>
				<div class="item-col item-col-header item-col-name">
				<?php if($this->request->query('sort') == 'cookie_type' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'cookie_type' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('cookie_type', $sortOrder,['escape' => false]); ?>
					<div> <span>&nbsp;<?php echo $this->Paginator->sort('cookie_type', 'Cookie Type'); ?></span> </div>                  
				</div>
				<div class="item-col item-col-header item-col-name">
				<?php if($this->request->query('sort') == 'cookie_time' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'cookie_time' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('cookie_time', $sortOrder,['escape' => false]); ?>
					<div> <span>&nbsp;<?php echo $this->Paginator->sort('cookie_time', 'Cookie Time'); ?></span> </div>                  
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
                  <div> <span>&nbsp;<?php echo $this->Paginator->sort('created', 'Created'); ?></span> </div>
               </div>
			   <div class="item-col item-col-header item-col-status">
               <?php if($this->request->query('sort') == 'withdrawl_status' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'withdrawl_status' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('withdrawl_status', $sortOrder,['escape' => false]); ?>
                  <div> <span>&nbsp;<?php echo $this->Paginator->sort('withdrawl_status', 'Withdrawl Status'); ?></span> </div>                  
               </div>
               <div class="item-col item-col-header fixed item-col-actions-dropdown"> <span><a>Action</a></span> </div>
            </div>
         </li>
         <?php
         if(empty($cookieSectionDetails)): ?>
            <li class="item">
				<div class="item-row">
				   <div>No results found</div>
				</div>
			 </li>
         <?php
         endif;
          foreach($cookieSectionDetails as $cookieSectionDetail): ?>
                <li class="item table-data" id="row_id_<?php echo $cookieSectionDetail->id;?>">
                    <div class="item-row">
                       <div class="item-col fixed item-col-check"> <label class="item-check">
                          <input type="checkbox" class="checkbox" value="<?php echo $cookieSectionDetail->id; ?>">
                          <span></span>
                          </label> 
                       </div>
                       <div class="item-col item-col-name">
                          <div class="item-heading">IP Address</div>
                          <div><?php echo $cookieSectionDetail->user_ipaddress;?></div>
                       </div>
                       <div class="item-col item-col-name">
                          <div class="item-heading">Cookie Type</div>
                          <div>  <?php echo $cookieSectionDetail->cookie_type; ?> </div>
                       </div>
					   <div class="item-col item-col-name">
                          <div class="item-heading">Cookie Time</div>
                          <div>  <?php echo $cookieSectionDetail->cookie_time; ?> </div>
                       </div>
					   <div class="item-col item-col-name">
                          <div class="item-heading">Added On</div>
                          <div>  <?php echo $cookieSectionDetail->created; ?> </div>
                       </div>
					   <div class="item-col item-col-status">
						  <div class="item-heading">Withdrawl Status</div>
						  <div data-id="status<?php echo $cookieSectionDetail->id; ?>">  <?php if($cookieSectionDetail->withdrawl_status == 1): echo "<b>Inactive</b>"; else: echo "Active"; endif; ?> </div>
					   </div>
                       <div class="item-col fixed item-col-actions-dropdown">
                          <div class="item-actions-dropdown active">
                             <div class="item-actions-block options">
                                <ul class="item-actions-list">
								<?php
								/*if( (array_key_exists('edit-banner-section',$session->read('permissions.'.strtolower('CookieConsents')))) && $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('edit-banner-section'))==1 ){
								?>
                                   <li>
                                      <a class="edit" href="<?php echo Router::url("/admin/banner-sections/edit-banner-section",true).'/'.base64_encode($cookieSectionDetail->id); ?>" title="Edit"> 
                                          <i class="fa fa-pencil"></i> 
                                      </a>
                                   </li>
								<?php
								}*/
								if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('CookieConsents')))) && $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('change-status'))==1 ){
								?>
								   <li>
									<?php if($cookieSectionDetail->withdrawl_status == 1): ?>
										<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $cookieSectionDetail->id; ?>',0);" title="Click to Active">
											<i class="fa fa-lock" aria-hidden="true"></i>
										</a>
									<?php else: ?>
										<a class="edit" href="javascript:void(0);" onclick="change_status('<?php echo $cookieSectionDetail->id; ?>',1);" title="Click to Inactive">
											<i class="fa fa-unlock" aria-hidden="true"></i>
										</a>
									<?php endif; ?>							 
								   </li>
								<?php
								}
								if( (array_key_exists('delete-cookie-consent',$session->read('permissions.'.strtolower('CookieConsents')))) && $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('delete-cookie-consent'))==1 ){
								?>
								   <li>
									<a class="remove" href="javascript:void(0);" onclick="delete_cookie_consent('<?php echo $cookieSectionDetail->id; ?>');" title="Delete">
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
   $form = ($this->request->params['paging']['CookieConsents']['page'] * $this->request->params['paging']['CookieConsents']['perPage']) - $this->request->params['paging']['CookieConsents']['perPage']+$cnt; 
   $to = ($this->request->params['paging']['CookieConsents']['page'] * $this->request->params['paging']['CookieConsents']['perPage'])-$this->request->params['paging']['CookieConsents']['perPage'] + $this->request->params['paging']['CookieConsents']['current']; ?>

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
if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('CookieConsents')))) && $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('change-status'))==1) && ((array_key_exists('delete-cookie-consent',$session->read('permissions.'.strtolower('CookieConsents')))) && $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('delete-cookie-consent'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete','activeAll','Active','inactiveAll','Inactive');
<?php
}else
if( ((array_key_exists('change-status',$session->read('permissions.'.strtolower('CookieConsents')))) && $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('change-status'))==1) && ((!array_key_exists('delete-cookie-consent',$session->read('permissions.'.strtolower('CookieConsents')))) && $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('delete-cookie-consent'))!=1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'activeAll','Active','inactiveAll','Inactive');
<?php
}
else if( ((!array_key_exists('change-status',$session->read('permissions.'.strtolower('CookieConsents')))) && $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('change-status'))!=1) && ((array_key_exists('delete-cookie-consent',$session->read('permissions.'.strtolower('CookieConsents')))) && $session->read('permissions.'.strtolower('CookieConsents').'.'.strtolower('delete-cookie-consent'))==1) ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete');
<?php
}
?>

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
			url: '<?php echo Router::url("/admin/cookie-consents/change-status/",true); ?>',
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
function delete_cookie_consent(id){
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
			url: '<?php echo Router::url("/admin/cookie-consents/delete-cookie-consent/",true); ?>',
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
				url: '<?php echo Router::url("/admin/cookie-consents/delete-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.type == 'success'){
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
				url: '<?php echo Router::url("/admin/cookie-consents/active-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						setTimeout(function () {
							swal({
								title: "Detail(s) successfully activated",
								type: "success",
								confirmButtonText: "OK",
								},
								function(){
									window.location.reload();
								});
						}, 500);						
					}else{
						swal("No detail(s) to mark as active", "", "warning");
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
				url: '<?php echo Router::url("/admin/cookie-consents/inactive-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result != ''){
						setTimeout(function () {
							swal({
								title: "Detail(s) successfully inactivated",
								type: "success",
								confirmButtonText: "OK",
								},
								function(){
									window.location.reload();
								});
						}, 500);						
					}else{
						swal("No detail(s) to mark as inactive", "", "warning");
					}
				}
			});
        });
}
</script>