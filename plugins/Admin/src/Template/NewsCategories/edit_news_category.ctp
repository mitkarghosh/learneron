<?php use Cake\Routing\Router; $session = $this->request->session();
$this->assign('needEditor', true);
$this->assign('editor_id', '#description'); 
?>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Edit Category
         <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <?php echo $this->Flash->render() ?>
   <?php echo $this->Form->create($existing_data, ['id' => 'login-form', 'novalidate' => 'novalidate', 'enctype'=>'multipart/form-data']); ?>
      <div class="card card-block">
	  <?php if($existing_data->parent_id != 0 ) : ?>
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Parent Category:
            </label>
            <div class="col-sm-4">
               <?php echo $this->Form->input('parent_id', ['type'=>'select', 'empty'=>'Select Parent Category', 'options'=>$parent_categories, 'value'=>$existing_data->parent_id, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Category Name', 'required'=>'' ]); ?>
            </div>
        </div>
		<?php endif; ?>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Name:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('name', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Category Name' ]); ?>
            </div>
         </div>
		<?php
		if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('NewsCategories')))) && $session->read('permissions.'.strtolower('NewsCategories').'.'.strtolower('change-status'))==1 ){
		?>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Status:
            </label>
            <div class="col-sm-2">
               <?php echo $this->Form->input('status', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Status', 'options' => ['A' => 'Active', 'I' => 'Inactive']]); ?>
            </div>
         </div>
		<?php
		}
		?>
         <div class="form-group row">
            <div class="col-sm-10 col-sm-offset-2">
               <?php echo $this->Form->button('Update',['type' => 'submit','class' => 'btn btn-primary']); ?>&nbsp;
			   <a href="<?php echo Router::url('/admin/news-categories/list-data',true); ?>" class="btn btn-primary">Cancel</a>
            </div>
         </div>
      </div>
   <?php echo $this->Form->end(); ?>
</article>