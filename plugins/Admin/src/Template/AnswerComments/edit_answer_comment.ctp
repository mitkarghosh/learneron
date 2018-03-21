<?php use Cake\Routing\Router; $session = $this->request->session();
$this->assign('needEditor', true);
$this->assign('editor_id', '.editorClass');
?>
<style>.btn-default{width:auto !important;} .col-sm-1 .checkbox{display:block;} .attireMainNav{display:none;}</style>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Edit Answer Comment
         <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <?php echo $this->Flash->render() ?>
   <?php
   echo $this->Form->create($existing_data, ['id' => 'edit-answer-form', 'novalidate' => 'novalidate']);
   ?>
    <div class="card card-block">
		<?php if(!empty($existing_data->comment_user)){?>
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Posted By:
            </label>
            <div class="col-sm-4">
				<span class="form-control boxed"><?php echo $existing_data->comment_user->name;?></span>
            </div>
        </div>
		<?php } ?>
	
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Comment:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('comment', ['type' => 'textarea', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => '', 'value' => $existing_data->comment]); ?>
            </div>
         </div>		 
		<?php
		if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('AnswerComments')))) && $session->read('permissions.'.strtolower('AnswerComments').'.'.strtolower('change-status'))==1 ){
		?>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Status:
            </label>
            <div class="col-sm-2">
               <?php echo $this->Form->input('status', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Status', 'options' => ['1' => 'Active', '0' => 'Inactive']]); ?>
            </div>
         </div>
		<?php
		}
		?>
         <div class="form-group row">
            <div class="col-sm-10 col-sm-offset-2">
               <?php echo $this->Form->button('Update',['type' => 'submit','class' => 'btn btn-primary']); ?>&nbsp;
			   <a href="<?php echo Router::url('/admin/answer-comments/list-data/'.base64_encode($answerid),true); ?>" class="btn btn-primary">Cancel</a>
            </div>
         </div>
      </div>
   <?php echo $this->Form->end(); ?>
</article>