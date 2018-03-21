<?php use Cake\Routing\Router; 
?>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Add New Blog Category
         <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <?php echo $this->Flash->render() ?>
   <?php echo $this->Form->create($new_blogCategory,['id' => 'login-form', 'novalidate' => 'novalidate', 'enctype'=>'multipart/form-data']); ?>
      <div class="card card-block">
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Category Name:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('category_name', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Category Name' ]); ?>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Status:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('status', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Status', 'options' => ['A' => 'Active', 'I' => 'In-Active']]); ?>
            </div>
         </div>

         <div class="form-group row">
            <div class="col-sm-10 col-sm-offset-2">
               <?php echo $this->Form->button('Add',['type' => 'submit','class' => 'btn btn-primary']); ?>
            </div>
         </div>
      </div>
   <?php echo $this->Form->end(); ?>
</article>