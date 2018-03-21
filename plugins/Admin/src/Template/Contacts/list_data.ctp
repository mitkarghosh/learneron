<?php use Cake\Routing\Router; $session = $this->request->session();
$this->assign('needEditorContact', true);
$this->assign('editor_id', '#message'); 
?>
<style>.btn-default{width:auto !important;} .col-sm-1 .checkbox{display:block;} .attireMainNav{display:none;} #ad_reply{height:150px; overflow-y: scroll;} .adminreply p{margin-bottom:5px;} hr{margin-top:0.5rem !important; margin-bottom:0.5rem !important;}</style>
<article class="content items-list-page">
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-6">
               <h3 class="title">
                  All Contacts
				  <a></a>
               </h3>
            </div>
         </div>
      </div>
      <div class="items-search">
         <form class="form-inline" action="<?php echo Router::url('/admin/contacts/list-data/',true); ?>" method="get">
            <div class="input-group">
               <span>
                  <input value="<?php if($this->request->query('search') !== null): echo $this->request->query('search'); endif; ?>" type="text" name="search" class="form-control boxed rounded-s" placeholder="Search by..." />
                </span>
                <span>
                   <select class="form-control" name="search_by">
                     <option value="email">Contacts Email</option>
                     <option value="phone_number">Contacts Phone</option>
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
				   <a title="Reset" class="btn btn-secondary rounded-s" href="<?php echo Router::url('/admin/contacts/list-data',true);?>">
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
               <?php if(!empty($contactDetails)): ?>
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
               <div class="item-col item-col-header item-col-phone_numner">
               <?php if($this->request->query('sort') == 'phone_numner' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'phone_numner' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('phone_numner', $sortOrder,['escape' => false]); ?>
                  <div> <span><?php echo $this->Paginator->sort('phone_numner', 'Phone'); ?></span> </div>
                  
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
                  <div> <span><?php echo $this->Paginator->sort('created', 'Contacted ON'); ?></span> </div>
               </div>
               <div class="item-col item-col-header fixed item-col-actions-dropdown"> <span><a>Action</a></span> </div>
            </div>
         </li>
         <?php
         if(empty($contactDetails)): ?>
            <li class="item">
				<div class="item-row">
				   <div>No results found</div>
				</div>
			 </li>
         <?php
         endif;
          foreach($contactDetails as $contact): ?>
                 <li class="item table-data" id="row_id_<?php echo $contact->id;?>">
                    <div class="item-row">
                       <div class="item-col fixed item-col-check"> <label class="item-check">
                          <input type="checkbox" class="checkbox" value="<?php echo $contact->id; ?>">
                          <span></span>
                          </label> 
                       </div>
                       <div class="item-col item-col-name">
                          <div class="item-heading">Name</div>
                          <div>  <?php echo $contact->name;?> </div>
                       </div>
                       <div class="item-col item-col-email">
                          <div class="item-heading">Email</div>
                          <div>  <?php echo $contact->email; ?> </div>
                       </div>
                       <div class="item-col item-col-phone_number">
                          <div class="item-heading">Phone</div>
                          <div>  <?php echo $contact->phone_number; ?> </div>
                       </div>
                       <div class="item-col item-col-created">
                          <div class="item-heading">Contact ON</div>
                          <div class="no-overflow"> <?php echo date('jS F Y',strtotime($contact->created)); ?> </div>
                       </div>
                       <div class="item-col fixed item-col-actions-dropdown">
                          <div class="item-actions-dropdown active">
                             <div class="item-actions-block options">
                                <ul class="item-actions-list">
								<?php
								if( (array_key_exists('reply',$session->read('permissions.'.strtolower('Contacts')))) && $session->read('permissions.'.strtolower('Contacts').'.'.strtolower('reply'))==1 ){
								?>
                                   <li>
                                      <a class="edit" href="#" id="<?php echo $contact->id; ?>" data-toggle="modal" data-target="#contact-modal" title="View and Reply"> 
                                          <i class="fa fa-eye"></i> 
                                      </a>
                                   </li>
								<?php
								}
								if( (array_key_exists('delete-contacts',$session->read('permissions.'.strtolower('Contacts')))) && $session->read('permissions.'.strtolower('Contacts').'.'.strtolower('delete-contacts'))==1 ){
								?>
									<li>
										<a class="remove" href="javascript:void(0);" onclick="delete_contact('<?php echo $contact->id; ?>');" title="Delete">
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
   $form = ($this->request->params['paging']['Contacts']['page'] * $this->request->params['paging']['Contacts']['perPage']) - $this->request->params['paging']['Contacts']['perPage']+$cnt; 
   $to = ($this->request->params['paging']['Contacts']['page'] * $this->request->params['paging']['Contacts']['perPage'])-$this->request->params['paging']['Contacts']['perPage'] + $this->request->params['paging']['Contacts']['current']; ?>

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
<div class="modal fade" id="contact-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-user"></i> <span class="blog_header">Contact Person Details</span></h4>
            </div>
            <div class="modal-body">
                <div class="detailsContent">
                  <p><b>Name:</b> <span class="username"></span></p>
                  <p><b>User Name:</b> <span class="user_name"></span></p>
                  <p><b>Email:</b> <span class="email"></span></p>
                  <p><b>Phone Number:</b> <span class="phone_number"></span></p>
                  <p><b>Contacted On:</b> <span class="contacted_on"></span></p>
                  <p><b>Message:</b> <span class="message"></span></p>
				  <div><b>Admin Replies:</b><p id="ad_reply"></p></div>
				  <p>&nbsp;</p>
                  <form name='contact_reply' action="javascript:void(0);" id='contact_reply' enctype="multipart/form-data" novalidate="novalidate">
					<input type="hidden" name="id" value="" class="user_id" />
                    <textarea name="message" id="message" class="form-control boxed" required="required"></textarea>
                    <p class="err_mag"></p>
                    <div id="msg_div"></div>
                    <input type="hidden" name="email" id="email_contacts" value="" row='5' ><br>
                    <input type="submit" class="btn btn-primary btn-sm rounded-s" id="reply_contact" value='Reply'>
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
<script type="text/javascript">
<?php
if( (array_key_exists('delete-contacts',$session->read('permissions.'.strtolower('Contacts')))) && $session->read('permissions.'.strtolower('Contacts').'.'.strtolower('delete-contacts'))==1 ){
?>
	var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete');
<?php
}
?>

$(document).ready(function(){
/* Reply Customer*/
$('#reply_contact').click(function(){
	var message = $('.panel-body').html();
	var cleanContent = message.replace(/(<([^>]+)>)/ig,"");
	if(cleanContent.length == 0){
		$('.err_mag').html('Please write something for the message').css({'color':'red'});
	}else{
		$("div#divLoading").addClass('show');
		$('.err_mag').html('');
		var email = $('#email_contacts').val();
		var id = $('.user_id').val();
		var message = $('#message').val();
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			url: '<?php echo Router::url("/admin/contacts/reply-users/",true); ?>',
			data: {id: id, message: message},			
			success: function(result){
				$("div#divLoading").remove();
				if(result.status == 'mail_sent'){
					var msg = "<div class='message success' onclick='this.classList.add('hidden')'>Email has been successfully sent.</div>";
					$('#reply_message').html(msg);
					setTimeout(function(){
						$('#contact_reply')[0].reset();
						$('#reply_message').html('');
						$('#contact-modal').modal('hide');
					},3000);
				}else{
					var msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the developers.</div>";
					$('#reply_message').html(msg);
					setTimeout(function(){
						$('#contact_reply')[0].reset();
						$('#reply_message').html('');
						$('#contact-modal').modal('hide');
					},3000);
				}
			}
		});
	}
});
/* End Reply Customer*/
  var localStorage = [];
  $('#contact-modal').on('shown.bs.modal', function (e) {
		var id = e.relatedTarget.id;
		$('.loading').hide();
		$('.error').hide();
		$('.detailsContent').show();
		$('.loading').show();
        $('.detailsContent').hide();
        var promise = $.getJSON('<?php echo Router::url("/admin/contacts/view/",true); ?>'+id);
        promise.done(function(response){
			localStorage[id] = response.data;
            $('.loading').hide();
            $('.error').hide();
            $('.detailsContent').show();
            $('.username').text(response.data.name);
            $('.user_name').text(response.data.user_name);
            $('.email').text(response.data.email);
            $('#email_contacts').val(response.data.email);
            $('.phone_number').text(response.data.phone_number);
            $('.contacted_on').text(response.data.created);
            $('.message').text(response.user_message);
			if(response.admin_reply.length > 0){
				$('#ad_reply').html('<span class="admin_replies">'+response.admin_reply+'</span>');
			}else{
				$('#ad_reply').html('<span class="admin_replies">N/A</span>');
			}
            $('.user_id').val(response.data.id);
          });
        promise.fail(function(response){
            $('.loading').hide();
            $('.detailsContent').hide();
            $('.error').show();
          });
	});

});

var selectedCheckBox = new checkbox(<?php echo $this->Paginator->param('count'); ?>,'deleteAll','Delete');

function delete_contact(id){
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
			url: '<?php echo Router::url("/admin/contacts/delete-contacts/",true); ?>',
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
				url: '<?php echo Router::url("/admin/contacts/delete-multiple/",true); ?>',
				data: {
					id: selectedCheckBox.id
				},
				success: function(result) {
					if(result.delete_count == 1){	//all contacts successfully deleted
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
					}else{
						swal(result.message, "", "error");
					}
				}
			});
        });
}
</script>