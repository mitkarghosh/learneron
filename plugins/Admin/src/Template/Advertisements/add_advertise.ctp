<?php use Cake\Routing\Router; $session = $this->request->session();?>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Add New Advertisement
         <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <?php echo $this->Flash->render() ?>
   <?php echo $this->Form->create($new_advertise,['id' => 'login-form', 'novalidate' => 'novalidate', 'enctype'=>'multipart/form-data']); ?>
      <div class="card card-block">
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">Page:</label>
			<div class="col-sm-3">
				<?php
				$options = ['homePage'=>'Home', 'postQuestion'=>'Post Question', 'allQuestions'=>'Browse All Questions', 'allUsers'=>'Users', 'newsListing'=>'News & Views'];
				echo $this->Form->input('page_name', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Status', 'empty' => 'Select Page', 'options' => $options]); ?>
			</div>
		 </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Link:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('link', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Link' ]); ?>
            </div>
         </div>         
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Image:
            </label>
            <div class="col-sm-10">
				<?php echo $this->Form->input('image', ['type'=>'file', 'required' => true, 'label' => false, 'class' => 'form-control boxed', 'accept'=>"image/*", 'onchange' => 'image_preview(event)', 'autocomplete' => 'off']); ?>
				<p class="error_msg"></p>
				<p class="sm_txt_nm">* Please upload jpg, png, jpeg files only, for best view please add above 728px x 92px image.</p>
				<output id='image_view' style="padding-top:0px;"></output>
            </div>
         </div>
		<?php
		if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('Advertisements')))) && $session->read('permissions.'.strtolower('Advertisements').'.'.strtolower('change-status'))==1 ){
		?>
		 <div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">Status:</label>
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
				<a href="<?php echo Router::url('/admin/advertisements/list-data',true); ?>" class="btn btn-primary">Cancel</a>
            </div>
         </div>
      </div>
   <?php echo $this->Form->end(); ?>
</article>
<script>
function image_preview(evt){
	var files = evt.target.files;
	var num = 0;
	$('.preview_image').remove();
	$('.remove_preview_image').remove();
	
	// Loop through the FileList and render image files as thumbnails.
	for (var i = 0, f; f = files[i]; i++) {
		// Only process image files.
		if (!f.type.match('image.*')) {
			$('.error_msg').html('Please upload valid image file').css({'color':'red'});
			$('#image').val('');
			continue;
		}
		var reader = new FileReader();
		// Closure to capture the file information.
		reader.onload = (function(theFile) {
			return function(e) {				
				// Render thumbnail.
				var span = document.createElement('span');
				
				var uploaded_file_name = escape(theFile.name);
				var uploaded_file_extension = uploaded_file_name.substring(uploaded_file_name.lastIndexOf('.')+1);
				
				if(uploaded_file_extension=='png' || uploaded_file_extension=='jpg' || uploaded_file_extension=='jpeg' || uploaded_file_extension=='JPEG'){
					$('.error_msg').html('');
					span.innerHTML = 
						[
						'<img class="hide_shown_image preview_image" style="width: 728px; height:92px; border: 1px solid #000; margin: 5px; padding: 5px" src="', 
						e.target.result,
						'" title="', escape(theFile.name), 
						'"/><a class="remove_preview_image remove" href="javascript:remove_image();"  style="color:#db0e1e;"><i class="fa fa-trash-o "></i></a>'
						].join('');			
				}else{
					$('.error_msg').html('Please upload valid image file').css({'color':'red'});
					$('#profile-pic').val('');
				}
				document.getElementById('image_view').insertBefore(span, null);
			};
		})(f);
		// Read in the image file as a data URL.
		reader.readAsDataURL(f);
	}
}
function remove_image(){
	$('output#image_view span').remove();
	$('#image').val('');
}
</script>