<?php use Cake\Routing\Router; $session = $this->request->session();
$this->assign('needEditor', true);
$this->assign('editor_id', '#description'); 
?>
<style>
#category_level_msg{color: #ff4444; display: block !important; font-size: 13px;}
</style>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Edit Question category
         <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <?php echo $this->Flash->render() ?>
   <?php echo $this->Form->create($existing_data, ['id' => 'login-form', 'novalidate' => 'novalidate', 'enctype'=>'multipart/form-data']); ?>
    <div class="card card-block">
	<?php if($existing_data->parent_id != 0): ?>
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Parent Category:
            </label>
            <div class="col-sm-4">
               <?php //echo $this->Form->input('parent_id', ['type'=>'select', 'empty'=>'Select Parent Category', 'options'=>$parent_categories, 'value'=>$existing_data->parent_id, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Category Name', 'required'=>'' ]); ?>
			   <select name="parent_id" id="parent_id" class="form-control boxed check_category_level" autocomplete="off">
					<option value="" data-id="">Select Parent Category</option>
			<?php
			if(!empty($parent_categories)){
				foreach($parent_categories as $key_category => $val_category){
			?>
					<option value="<?php echo $key_category;?>" data-level="<?php echo $val_category['level'];?>" <?php if($key_category==$existing_data->parent_id)echo 'selected';?>><?php echo $val_category['name'];?></option>
			<?php
				}
			}
			?>
				</select>
				<div id="category_level_msg"></div>
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
		if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('QuestionCategories')))) && $session->read('permissions.'.strtolower('QuestionCategories').'.'.strtolower('change-status'))==1 ){
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
			   <a href="<?php echo Router::url('/admin/question-categories/list-data',true); ?>" class="btn btn-primary">Cancel</a>
            </div>
         </div>
      </div>
   <?php echo $this->Form->end(); ?>
</article>
<script>
$('.check_category_level').on('change', function(){
	var max_level = $(this).find(':selected').data('level');
	if(max_level != '' && max_level == 4){
		$('#category_level_msg').html('You have reached maximum category level.');
		$('.check_category_level').val(<?php echo $existing_data->parent_id;?>);
		setTimeout(function(){
			$('#category_level_msg').html('');
		},3000);
	}else{
		$('#category_level_msg').html('');
	}
});
</script>