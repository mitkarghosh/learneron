<?php use Cake\Routing\Router; $session = $this->request->session();
$this->assign('needEditor', true);
$this->assign('editor_id', '.editorClass');
?>
<?php echo $this->Html->script('/admin/multiselect/build.min.js'); ?>
<?php echo $this->Html->css('/admin/multiselect/fastselect.min.css') ?>
<?php echo $this->Html->script('/admin/multiselect/fastselect.standalone.js'); ?>
<style>.btn-default{width:auto !important;} .col-sm-1 .checkbox{display:block;} .attireMainNav{display:none;}</style>
<article class="content item-editor-page">
	<div class="title-block">
		<h3 class="title">
			Add New Question
			<span class="sparkline bar" data-type="bar"></span>
		</h3>
	</div>
   <?php echo $this->Flash->render() ?>
   <?php echo $this->Form->create($new_question,['id' => 'login-form', 'novalidate' => 'novalidate']); ?>
	<div class="card card-block">
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Category:
            </label>
            <div class="col-sm-4">
               <?php echo $this->Form->input('category_id', ['type'=>'select', 'empty'=>'Select Category', 'options'=>$question_categories, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Category Name', 'required'=>true ]); ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Question:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('name', ['type' => 'textbox', 'required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Question title' ]); ?>
            </div>
        </div>
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Description:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('short_description', ['type' => 'textarea', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Eg. Description']); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Learning Goal:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('learning_goal', ['type' => 'textarea', 'required' => false, 'label' => false, 'class' => 'editorClass form-control boxed', 'placeholder' => '']); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Starting Level:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('starting_level', ['type' => 'textarea', 'required' => false, 'label' => false, 'class' => 'editorClass form-control boxed', 'placeholder' => '']); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Budget & other constraints:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('budget_constraints', ['type' => 'textarea', 'required' => false, 'label' => false, 'class' => 'editorClass form-control boxed', 'placeholder' => '']); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Optional input on preferred learning mode:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('preferred_learning_mode', ['type' => 'textarea', 'required' => false, 'label' => false, 'class' => 'editorClass form-control boxed', 'placeholder' => '']); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Tags:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('tags', ['type'=>'select', 'empty'=>'', 'options'=>$all_tags, 'label' => false, 'class' => 'multipleSelectTags form-control boxed', 'placeholder' => 'Tags', 'multiple'=>true, 'required'=>true ]); ?>
            </div>
         </div>
		 <!--<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Is Featured?:
            </label>
            <div class="col-sm-1">
               <?php echo $this->Form->input('is_featured', ['type'=>'checkbox', 'label' => false, 'class' => '', 'required'=>false, 'div' => false, 'value' => '1' ]); ?>
            </div>
         </div>-->
		<?php
		if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('Questions')))) && $session->read('permissions.'.strtolower('Questions').'.'.strtolower('change-status'))==1 ){
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
               <?php echo $this->Form->button('Add',['type' => 'submit','class' => 'btn btn-primary']); ?>&nbsp;
				<a href="<?php echo Router::url('/admin/questions/list-data',true); ?>" class="btn btn-primary">Cancel</a>
            </div>
         </div>
      </div>
	<?php echo $this->Form->end(); ?>   
</article>
<script>
	$('.multipleSelectTags').fastselect();
</script>