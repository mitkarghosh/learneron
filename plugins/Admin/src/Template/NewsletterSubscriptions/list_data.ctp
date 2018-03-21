<?php use Cake\Routing\Router;
$this->assign('needEditorContact', true);
$this->assign('editor_id', '#message'); 
?>
<article class="content items-list-page">
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-6">
               <h3 class="title">
                  All Subscriber<?php if(isset($this->request->params['pass'][0])): echo "&nbsp;Trash"; endif; ?>
                  <a href="<?php echo Router::url('/admin/newsletter-subscriptions/add-contact',true); ?>" style='display: none;' class="btn btn-primary btn-sm rounded-s">
                  Add New
                  </a>
               </h3>
               <p class="title-description"> List of Subscriber </p>
            </div>
         </div>
      </div>
      <div class="items-search">
         <form class="form-inline" action="<?php echo Router::url('/admin/newsletter-subscriptions/list-data/',true); ?>" method="get">
            <div class="input-group">
               <span>
                  <input value="<?php if($this->request->query('search') !== null): echo $this->request->query('search'); endif; ?>" type="text" name="search" class="form-control boxed rounded-s" placeholder="Search by..." />
                </span>
                <span>
                   <select class="form-control" name="search_by">
                     <option value="email">Subscriber Email</option>
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
               <div class="item-col fixed item-col-check">
               <?php if(!empty($newsletterSubscriptionDetails)): ?>
                  <label class="item-check" id="select-all-items">
                      <input type="checkbox" class="checkbox">
                      <span></span>
                  </label> 
                <?php endif; ?>
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
               <div class="item-col item-col-header item-col-created">
               <?php if($this->request->query('sort') == 'created' && $this->request->query('direction') == 'asc'):
                            $sortOrder = '<i class="fa fa-sort-desc" aria-hidden="true"></i>';
                        elseif($this->request->query('sort') == 'created' && $this->request->query('direction') == 'desc'):
                            $sortOrder = '<i class="fa fa-sort-asc" aria-hidden="true"></i>';
                        else:
                            $sortOrder = '<i class="fa fa-sort" aria-hidden="true"></i>';
                        endif;
                            echo $this->Paginator->sort('created', $sortOrder,['escape' => false]); ?>
                  <div> <span><?php echo $this->Paginator->sort('created', 'Subscribed ON'); ?></span> </div>
               </div>
               <div class="item-col item-col-header fixed item-col-actions-dropdown"> <span>Action</span> </div>
            </div>
         </li>
         <?php
         if(empty($newsletterSubscriptionDetails)): ?>
            <li class="item">
                    <div class="item-row">
                       <div>No results found</div>
                    </div>
                 </li>
         <?php
         endif;
          foreach($newsletterSubscriptionDetails as $contact): ?>
                 <li class="item table-data">
                    <div class="item-row">
                       <div class="item-col fixed item-col-check"> <label class="item-check">
                          <input type="checkbox" class="checkbox" value="<?php echo $contact->id; ?>">
                          <span></span>
                          </label> 
                       </div>
                       <div class="item-col item-col-email">
                          <div class="item-heading">Email</div>
                          <div>  <?php echo $contact->email; ?> </div>
                       </div>
                       <div class="item-col item-col-created">
                          <div class="item-heading">Subscribed ON</div>
                          <div class="no-overflow"> <?php echo date('d M Y',strtotime($contact->created)); ?> </div>
                       </div>
                       <div class="item-col fixed item-col-actions-dropdown">
                          <div class="item-actions-dropdown active">
                             <div class="item-actions-block options">
                                <ul class="item-actions-list">
                                   <li>
                                      <a class="edit" href="#" id="<?php echo $contact->id; ?>" data-toggle="modal" data-target="#contact-modal" title="Reply Subscriber"> 
                                          <i class="fa fa-reply"></i> 
                                      </a>
                                   </li>
                                   <!-- <li>
                                      <a class="edit" data-status="<?php echo $contact->status; ?>" data-id="<?php echo $contact->id; ?>" href="javascript:void(0)" onclick="changeStatus(this)" title="<?php if($contact->status == 'A'): echo "Click to In-Active"; else: echo "Click to Active"; endif; ?>">
                                      <?php if($contact->status == 'I'): ?>
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                      <?php elseif($contact->status == 'A'): ?>
                                        <i class="fa fa-unlock" aria-hidden="true"></i>
                                      <?php endif; ?>
                                      </a>
                                   </li> -->
                                   <li>
                                  <?php if(!isset($this->request->params['pass'][0]) & 0): 
                                          $url = Router::url("/admin/newsletter-subscriptions/trash/",true);
                                      else:
                                          $url = Router::url("/admin/newsletter-subscriptions/delete/",true);
                                   endif;
                                   ?>
                                      <a class="remove" href="<?php echo $url.$this->Crypt->hash($contact->id); ?>" onclick="return confirm('Are you sure you want to delete?')" title="Delete">
                                        <i class="fa fa-trash-o "></i> 
                                      </a>
                                   </li>
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
   $form = ($this->request->params['paging']['NewsletterSubscriptions']['page'] * $this->request->params['paging']['NewsletterSubscriptions']['perPage']) - $this->request->params['paging']['NewsletterSubscriptions']['perPage']+1; 
   $to = ($this->request->params['paging']['NewsletterSubscriptions']['page'] * $this->request->params['paging']['NewsletterSubscriptions']['perPage'])-$this->request->params['paging']['NewsletterSubscriptions']['perPage'] + $this->request->params['paging']['NewsletterSubscriptions']['current']; ?>

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
                <h4 class="modal-title"><i class="fa fa-user"></i> <span class="blog_header">Subscriber Details</span></h4>
            </div>
            <div class="modal-body">
                <div class="detailsContent">
                  <p><b>Email:</b> <span class="email"></span></p>
                  <p><b>Subscribed On:</b> <span class="contacted_on"></span></p>
                  <form name='contact_reply' action="javascript:void(0);" id='contact_reply' enctype="multipart/form-data" novalidate="novalidate">
                   
                    <textarea name="message" id="message" class="form-control boxed" required="required"></textarea>
                    <p class="err_mag"></p>
                    <div id="msg_div"></div>
                    <input type="hidden" name="email" id="email_contacts" value="" row='5' ><br>
                    <input type="submit" class="btn btn-primary btn-sm rounded-s" id="reply_contact" value='Send Message'>
                  </form>
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
/* Reply Customer*/
$('#reply_contact').click(function(){
  var message = $('.panel-body').html();
  if(message.length<100){
    $('.err_mag').html('Please write atleast 100 character for the message').css({'color':'red'});
  }else{
    $("div#divLoading").addClass('show');
    $('.err_mag').html('');
    var email = $('#email_contacts').val();
    var promise = $.post('<?php echo Router::url("/admin/newsletter-subscriptions/reply-customer/",true); ?>',JSON.stringify({message:message,email:email}));
        promise.done(function(response){
            var data = JSON.parse(response);
            if(data.status=='mail_sent'){
              var xx = "<div class='message success'>Your message has been sent.</div>";
              $('#msg_div').html(xx);
              setTimeout(function(){
                $('#msg_div').html('');
              },3000);
              $('.panel-body').html('')
            }else{
              var xx = "<div class='message error' >There was an unexpected error. Try again later.</div>";
              $('#msg_div').html(xx);
              setTimeout(function(){
                $('#msg_div').html('');
              },3000);
            }
            $("div#divLoading").removeClass('show');
          });
        promise.fail(function(response){
           var xx = "<div class='message error' >There was an unexpected error. Try again later.</div>";
              $('#msg_div').html(xx);
              setTimeout(function(){
                $('#msg_div').html('');
              },3000);
            $("div#divLoading").removeClass('show');
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
      if(typeof localStorage[id] !== "undefined"){
        $('.email').text(localStorage[id].email);
        $('#email_contacts').val(localStorage[id].email);
        $('.contacted_on').text(localStorage[id].created);
      }else{
        $('.loading').show();
        $('.detailsContent').hide();
        var promise = $.getJSON('<?php echo Router::url("/admin/newsletter-subscriptions/view/",true); ?>'+id);
        promise.done(function(response){
            localStorage[id] = response.data;
            $('.loading').hide();
            $('.error').hide();
            $('.detailsContent').show();
            $('.email').text(response.data.email);
            $('#email_contacts').val(response.data.email);
            $('.contacted_on').text(response.data.created);
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
       url: '<?php if(!isset($this->request->params['pass'][0]) & 0): echo Router::url("/admin/newsletter-subscriptions/trash-multiple/",true); else: echo Router::url("/admin/newsletter-subscriptions/delete-multiple/",true); endif; ?>',
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
    var promise = $.post('<?php echo Router::url("/admin/newsletter-subscriptions/status/",true); ?>',JSON.stringify({id: $(obj).data('id'),status: $(obj).data('status')}));
    promise.done(function(response){
      var response = $.parseJSON(response);
      console.log(response.data_status);
      selectedCheckBox.showMessage(response.msg,response.class);
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
    });
    promise.fail(function(response){
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
</script>