<?php use Cake\Routing\Router; 
$this->assign('needEditor', true);
$this->assign('editor_id', '#description');
?>
<style>.btn-default{width:auto !important;}</style>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Edit <?php echo $cmsDetails->page_section; ?>
         <span class="sparkline bar" data-type="bar"></span>
         <small class="pull-right"><a href="<?php echo Router::url(array('plugin' => 'Admin','controller' => 'cms','action' => 'listData')); ?>"> Back to list</a></small>
      </h3>
   </div>
   <?php echo $this->Flash->render() ?>
   <?php echo $this->Form->create($cmsDetails,['id' => 'login-form', 'novalidate' => 'novalidate']); ?>
      <div class="card card-block">
      <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Title:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('title', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Eg. Title' ]); ?>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Description:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('description', ['type' => 'textarea', 'required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Eg. Description']); ?>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Status:
            </label>
            <div class="col-sm-2">
               <?php echo $this->Form->input('status', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Status', 'options' => ['A' => 'Active', 'I' => 'In-Active']]); ?>
            </div>
         </div>
         <div class="form-group row">
            <div class="col-sm-10 col-sm-offset-2">
               <?php echo $this->Form->button('Update',['type' => 'submit','class' => 'btn btn-primary']); ?>&nbsp;
			   <a href="<?php echo Router::url('/admin/cms/list-data',true); ?>" class="btn btn-primary">Cancel</a>
            </div>
         </div>
      </div>
   <?php echo $this->Form->end(); ?>
</article>
<script type="text/javascript">
   $(window).on('load',function(){
      $('img.propertyImage').each(function(){
         $(this).attr('src',$(this).data('src'));
      });
   });

   function deleteImage(id){
     var promise = $.post('<?php echo Router::url("/admin/property/delete-image/",true); ?>',JSON.stringify({id: id}));
     promise.done(function(response){
         $('#anchor_'+id).remove();
         $('#image_'+id).attr('src','<?php echo Router::url("/admin/images/deleted.jpg"); ?>');
     });
     promise.fail(function(response){

     });
   }
</script>