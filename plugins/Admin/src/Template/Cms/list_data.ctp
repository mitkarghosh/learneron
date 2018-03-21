<?php use Cake\Routing\Router; $session = $this->request->session(); ?>
<article class="content items-list-page">
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-6">
               <h3 class="title">
                  CMS Pages<?php if(isset($this->request->params['pass'][0])): echo "&nbsp;Trash"; endif; ?>
                  <!-- <a href="<?php echo Router::url('/admin/cms/add-cms',true); ?>" class="btn btn-primary btn-sm rounded-s">
                  Add
                  </a> -->
                  <?php /*if(!isset($this->request->params['pass'][0])): ?>
                      <a href="<?php echo Router::url('/admin/cms/list-data/',true).'/trash'; ?>" class="btn btn-warning btn-sm rounded-s">
                          <i class="fa fa-trash-o text-danger"></i> View Trash
                      </a>
                <?php else: ?>
                      <a href="<?php echo Router::url('/admin/cms/list-data/',true); ?>" class="btn btn-primary btn-sm rounded-s">
                            View cms
                      </a>
                <?php endif;*/ ?>
               </h3>
               <p class="title-description">&nbsp;</p>
            </div>
         </div>
      </div>
      <div class="items-search">
         <form class="form-inline" action="<?php echo Router::url('/admin/cms/list-data/',true); ?>" method="get">
            <div class="input-group">
               <span>
                  <input value="<?php if($this->request->query('search') !== null): echo $this->request->query('search'); endif; ?>" type="text" name="search" class="form-control boxed rounded-s" placeholder="Search by..." />
                </span>
                <span>
                   <select class="form-control" name="search_by">
                     <option value="title">Page Title</option>
                     <option value="description">Description</option>
                   </select>
                   <?php if($this->request->query('search') !== null): ?>
					  <script type="text/javascript">
						$('select[name="search_by"]').val("<?php echo $this->request->query('search_by'); ?>");
					  </script>
                    <?php endif; ?>
               </span>
                <span class="input-group-btn">
                   <button class="btn btn-secondary rounded-s" type="submit">
                        <i class="fa fa-search"></i>
                   </button>
               </span>
            </div>
         </form>
      </div>
   </div>
   <div class="card items">
   <?= $this->Flash->render() ?>
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
               <!-- <div class="item-col fixed item-col-check">
               <?php if(!empty($cmsDetails)): ?>
                  <label class="item-check" id="select-all-items">
                      <input type="checkbox" class="checkbox">
                      <span></span>
                  </label> 
                <?php endif; ?>
               </div> -->
               <div class="item-col item-col-header item-col-status">
                  <div> <span><?php echo $this->Paginator->sort('page_section', 'Page or Section'); ?></span> </div>
                  <?php if($this->request->query('sort') == 'page_section' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'page_section' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('page_section', $sortOrder,['escape' => false]); ?>
               </div>
               <div class="item-col item-col-header item-col-status">
                  <div> <span><?php echo $this->Paginator->sort('title', 'Title'); ?></span> </div>
                  <?php if($this->request->query('sort') == 'title' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'title' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('title', $sortOrder,['escape' => false]); ?>
               </div>
               <div class="item-col item-col-header item-col-name">
                  <div> <span><?php echo $this->Paginator->sort('description', 'Description'); ?></span> </div>
                  <?php if($this->request->query('sort') == 'description' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'description' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('description', $sortOrder,['escape' => false]); ?>
               </div>

               <div class="item-col item-col-header item-col-modified">
                  <div> <span><?php echo $this->Paginator->sort('modified', 'Last Updated'); ?></span> </div>
                  <?php if($this->request->query('sort') == 'modified' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'modified' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('modified', $sortOrder,['escape' => false]); ?>
               </div>
               <div class="item-col item-col-header fixed item-col-actions-dropdown">Action </div>
            </div>
         </li>
         <?php
         if(empty($cmsDetails)): ?>
            <li class="item">
				<div class="item-row">
				   <div>No results found</div>
				</div>
			 </li>
         <?php
         endif;
          foreach($cmsDetails as $cmsDetail): ?>
                 <li class="item table-data">
                    <div class="item-row">
                       <!-- <div class="item-col fixed item-col-check"> <label class="item-check">
                          <input type="checkbox" class="checkbox" value="<?php echo $cmsDetail->id; ?>">
                          <span></span>
                          </label> 
                       </div> -->
                       <div class="item-col item-col-status">
                          <div class="item-heading">Page or Section</div>
                          <div data-id="status<?php echo $cmsDetail->id; ?>">  <?php echo $cmsDetail->page_section; ?> </div>
                       </div>
                       <div class="item-col item-col-status">
                          <div class="item-heading">Title</div>
                          <div data-id="status<?php echo $cmsDetail->id; ?>">  <?php echo $cmsDetail->title; ?> </div>
                       </div>
                       <div class="item-col item-col-name">
                          <div class="item-heading">Name</div>
                          <div>  <?php echo substr(strip_tags($cmsDetail->description),0,100).'..'; ?> </div>
                       </div>
                       <div class="item-col item-col-created">
                          <div class="item-heading">Updated</div>
                          <div class="no-overflow"> <?php echo date('dS M Y',strtotime($cmsDetail->modified)); ?> </div>
                       </div>
                       <div class="item-col fixed item-col-actions-dropdown">
                          <div class="item-actions-dropdown active">
                             <div class="item-actions-block options">
                                <ul class="item-actions-list">
								<?php
								if( (array_key_exists('edit-cms',$session->read('permissions.'.strtolower('Cms')))) && $session->read('permissions.'.strtolower('Cms').'.'.strtolower('edit-cms'))==1 ){
								?>
                                   <li>
                                      <a class="edit" href="<?php echo Router::url("/admin/cms/edit-cms",true).'/'.base64_encode($cmsDetail->id); ?>" title="Edit"> 
                                          <i class="fa fa-pencil"></i> 
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
   $form = ($this->request->params['paging']['Cms']['page'] * $this->request->params['paging']['Cms']['perPage']) - $this->request->params['paging']['Cms']['perPage']+$cnt; 
   $to = ($this->request->params['paging']['Cms']['page'] * $this->request->params['paging']['Cms']['perPage'])-$this->request->params['paging']['Cms']['perPage'] + $this->request->params['paging']['Cms']['current']; ?>

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
<!-- /.modal -->
<div class="modal fade" id="cms-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-user"></i> <span class="cms_name">Country Name</span></h4>
            </div>
            <div class="modal-body">
                <div class="detailsContent">
                  <p>Country Name: <span class="country_name"></span></p>
                  <p>cms Name: <span class="cms_name"></span></p>
                  <p>ISO Code: <span class="iso_code"></span></p>
                  <p>Status: <span class="status"></span></p>
                  <p>Last Updated On: <span class="modified"></span></p>
                  <p>Created: <span class="created"></span></p>
                  <a class="edit_btn" href="#">Edit cms</a>
                </div>
                <div class="loading" style="display:none">
                  <p>Getting the data...</p>
                </div>
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
<script type="text/javascript">

$(document).ready(function(){
  var localStorage = [];
  $('#cms-modal').on('shown.bs.modal', function (e) {
      var id = e.relatedTarget.id;
      $('.loading').hide();
      $('.error').hide();
      $('.detailsContent').show();
      if(typeof localStorage[id] !== "undefined"){
        $('.country_name').text(localStorage[id].country.country_name);
        $('.cms_name').text(localStorage[id].cms_name);
        $('.iso_code').text(localStorage[id].iso_code);
        if(localStorage[id].status == 'A'){
          $('.status').text('Active');
        }else{
          $('.status').text('In-Active');
        }
        $('.modified').text(localStorage[id].modified);
        $('.created').text(localStorage[id].created);
        $('.edit_btn').attr('href','<?php echo Router::url("/admin/cms/edit-cms/",true); ?>'+id);
      }else{
        $('.loading').show();
        $('.detailsContent').hide();
        var promise = $.getJSON('<?php echo Router::url("/admin/cms/view/",true); ?>'+id);
        promise.done(function(response){
            localStorage[id] = response.data;
            $('.loading').hide();
            $('.error').hide();
            $('.detailsContent').show();
            $('.country_name').text(response.data.country.country_name);
            $('.cms_name').text(response.data.cms_name);
            $('.iso_code').text(response.data.iso_code);
            if(response.data.status == 'A'){
              $('.status').text('Active');
            }else{
              $('.status').text('In-Active');
            }
            $('.edit_btn').attr('href','<?php echo Router::url("/admin/cms/edit-cms/",true); ?>'+id);
            $('.modified').text(response.data.modified);
            $('.created').text(response.data.created);
          });
        promise.fail(function(response){
            $('.loading').hide();
            $('.detailsContent').hide();
            $('.error').show();
          });
      }
  });

});

var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll');

function deleteAll(){
  if(confirm("Are you sure you want to delete the record?")){
    selectedCheckBox.showMessage('Deleting the records...','info');
    $.ajax({
       type: 'POST',
       dataType: 'JSON',
       url: '<?php if(!isset($this->request->params['pass'][0]) & 0): echo Router::url("/admin/cms/trash-multiple/",true); else: echo Router::url("/admin/cms/delete-multiple/",true); endif; ?>',
       data: {
          id: selectedCheckBox.id
       },
        error: function(error){
          if(error.status == 404){
            selectedCheckBox.showMessage('The url does not exist anymore. Try contacting the developers.','danger');
          }else
            if(error.status == 408){
              selectedCheckBox.showMessage('The server is busy right now. Try again after a while.','danger');
            }else{
              selectedCheckBox.showMessage('There was an unexpected error. Try contacting the developers or try again after a while.','danger');
            }
        },
       success: function(data) {
          <?php if(!isset($this->request->params['pass'][0]) & 0): ?>
              selectedCheckBox.showMessage('Selected records are moved to trash.','success');
            <?php else: ?>
              selectedCheckBox.showMessage('Selected records are parmanently deleted.','success');
         <?php endif; ?>
         window.location.reload();
       }
    });
  }
}

var statusAjax = '', timeOut = '';
function changeStatus(obj){
  if(statusAjax != '' && statusAjax !== 'undefined'){
    statusAjax.abort();
  }else{
    if(timeOut != '' && timeOut !== 'undefined'){
      clearTimeout(timeOut);
    }
    selectedCheckBox.showMessage('Changing the status...','info');
    var className = $('a[data-id="'+$(obj).data('id')+'"] i').attr('class');
    $('a[data-id="'+$(obj).data('id')+'"] i').attr('class','fa fa-spinner fa-pulse fa-fw');
    promise = statusAjax;
    var promise = $.post('<?php echo Router::url("/admin/cms/status/",true); ?>',JSON.stringify({id: $(obj).data('id'),status: $(obj).data('status')}));
    promise.done(function(response){
      var response = $.parseJSON(response);
      selectedCheckBox.showMessage(response.msg,response.class);
      if(response.status == 'success'){
        var statusClass = 'fa-lock';
        var status = "In-Active";
        $('a[data-id="'+response.id+'"]').attr('title','Click to Active');
        if(response.data_status == 'A'){
          statusClass = 'fa-unlock';
          status = "Active";
          $('a[data-id="'+response.id+'"]').attr('title','Click to In-Active');
        }
        $('a[data-id="'+response.id+'"] i').attr('class','fa '+statusClass);
        $('a[data-id="'+response.id+'"]').data('status',response.data_status);
        $('div[data-id="status'+response.id+'"]').text(status);
      }
    });
    promise.fail(function(){
      selectedCheckBox.showMessage('There was an unexpected error. Try contacting the developer.','danger');
      $('a[data-id="'+$(obj).data('id')+'"] i').attr('class',className);
    });
    promise.always(function(){
      timeOut = setTimeout(function(){
        selectedCheckBox.removeMessage();
      },4000);
    });
  }
}

/*$(document).on('click', '.pagination a', function() {
  var target = $(this).attr('href');
  if(!target)
    return false;
  $.get(target, function(data) {
    $('.content').html( data );
  }, 'html');
  return false;
});*/
</script>