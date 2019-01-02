<?php use Cake\Routing\Router; $session = $this->request->session();
$this->assign('needEditor', true);
$this->assign('editor_id', '#description1'); 
?>
<style>.btn-default{width:auto !important;}</style>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Edit News
         <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <?php echo $this->Flash->render() ?>
   <?php echo $this->Form->create($existing_data, ['id' => 'login-form', 'novalidate' => 'novalidate', 'enctype'=>'multipart/form-data']); ?>
		<input type="hidden" name="news_id" id="news_id" value="<?php echo $existing_data->id;?>" />
      <div class="card card-block">
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Title:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('name', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Title' ]); ?>
				<small style="float: right; color:#999;">
					<span id="saving_draft_name" class="draft_msg"></span>
				</small>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Category:
            </label>
            <div class="col-sm-3">
				<?php echo $this->Form->input('category_id', ['type'=>'select', 'required' => true, 'label' => false, 'class' => 'form-control boxed', 'empty' => 'Select a Category', 'options'=>$all_category ]); ?>
				<small style="float: right; color:#999;">
					<span id="saving_draft_category" class="draft_msg"></span>
				</small>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Image:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('image', ['type'=>'file', 'label' => false, 'class' => 'form-control boxed', 'accept'=>"image/*", 'onchange' => 'image_preview(event)', 'autocomplete' => 'off']); ?>
               <p class="error_msg"></p>
               <p class="sm_txt_nm">* Please upload jpg, png, jpeg, bmp files only, for best view please add above 899px x 390px image.</p>
				<?php
				if($existing_data->image !=''){
					$image = $existing_data->image;
					$image = Router::url('/uploads/news/thumb/', true).$image;
				}else{
					$image = 'no-image.png';
					$image = Router::url('/images/', true).$image;
				}
				?>
				<img src="<?php echo $image; ?>" width='100' height='75' style="border:1px solid #000; padding:5px;" />
				<output id='image_view' style="padding-top:0px;"></output>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Descriptions:
            </label>
            <div class="col-sm-10">
				<?php echo $this->Form->input('description', ['type'=>'textarea', 'id' => 'description1', 'required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Message' ]); ?>
				<small style="float: right; color:#999;">
					<span id="saving_draft_description" class="draft_msg"></span>
				</small>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Meta Keywords:
            </label>
            <div class="col-sm-10">
				<?php echo $this->Form->input('meta_keywords', ['label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Add keywords with comma separated values' ]); ?>
				<small style="float: right; color:#999;">
					<span id="saving_draft_meta_keywords" class="draft_msg"></span>
				</small>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Meta Description:
            </label>
            <div class="col-sm-10">
				<?php echo $this->Form->input('meta_description', ['type'=>'textarea', 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Add meta description' ]); ?>
				<small style="float: right; color:#999;">
					<span id="saving_draft_meta_description" class="draft_msg"></span>
				</small>
            </div>
         </div>
		<?php
		if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('News')))) && $session->read('permissions.'.strtolower('News').'.'.strtolower('change-status'))==1 ){
		?>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Status:
            </label>
            <div class="col-sm-2">
				<select name="status" id="status" class="form-control boxed" required>
					<option value="D" <?php if($existing_data->status=='D')echo 'selected';?>>Draft</option>
					<option value="A" <?php if($existing_data->status=='A')echo 'selected';?>>Active</option>
					<option value="I" <?php if($existing_data->status=='I')echo 'selected';?>>Inactive</option>
				</select>			
               <?php //echo $this->Form->input('status', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Status', 'options' => ['A' => 'Active', 'I' => 'Inactive']]); ?>
            </div>
         </div>
		<?php
		}
		?>
         <div class="form-group row">
            <div class="col-sm-10 col-sm-offset-2">
               <?php echo $this->Form->button('Update',['type' => 'submit','class' => 'btn btn-primary']); ?>&nbsp;
				<a href="<?php echo Router::url('/admin/news/list-data',true); ?>" class="btn btn-primary">Cancel</a>
            </div>
         </div>
      </div>
   <?php echo $this->Form->end(); ?>
</article>
<script type="text/javascript">
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
						'<img class="hide_shown_image preview_image" style="width: 150px; border: 1px solid #000; margin: 5px; padding: 5px" src="', 
						e.target.result,
						'" title="', escape(theFile.name), 
						'"/><a class="remove_preview_image remove" href="javascript:remove_image();"  style="color:#db0e1e;"><i class="fa fa-trash-o "></i></a>'
						].join('');			
				}else{
					$('.error_msg').html('Please upload valid image file').css({'color':'red'});
					$('#image').val('');
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

//setup before functions
var typingTimer1;                //timer identifier
var doneTypingInterval1 = 2000;  //time in ms, 2 second for example
var $name = $('#name');
$(document).ready(function(){
	$name.on('keyup', function () {
		clearTimeout(typingTimer1);
		typingTimer1 = setTimeout(doneTyping, doneTypingInterval1);
	});
	
	$name.on('keydown', function () {
		clearTimeout(typingTimer1);
	});
});
function doneTyping () {
	var website_url = '<?php echo Router::url("/admin/news/edit-news-as-draft/",true); ?>';
	$('#saving_draft_name').html('Saving...');
	$.ajax({
		type : 'POST',
		url  : website_url,
		data : $('#login-form').serialize(),
		success : function(response){
			if(response==1)
				$('#saving_draft_name').html('Saved');
			else if(response==0)
				$('#saving_draft_name').html('Title already exist');
			else if(response==2)
				$('#saving_draft_name').html('');
		},
		error : function(){
		}
	});			
	setTimeout(function(){
		$('.draft_msg').html('');
	},3000);
}

function uploadImage1(image) {
	var data = new FormData();
	data.append("image", image);
	$("div#divLoading").addClass('show');
	$.ajax({
		url: '<?php echo Router::url("/admin/admin-details/upload-editor-image/", true); ?>',
		cache: false,
		contentType: false,
		processData: false,
		data: data,
		type: "post",
		success: function(url) {
			$('.note-icon-picture').trigger('click');
			$('.note-image-url').val(url);
			$('.note-image-btn').trigger("click");
			$("div#divLoading").removeClass('show');
		},
		error: function(data) {
			console.log(data);
			$("div#divLoading").removeClass('show');
		}
	});
}

$(document).ready(function(){
	$('#description1').summernote({	
		popover: {
			image: [],
			link: [],
			air: []
		},
		height:250,
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'italic', 'underline', 'clear']],
			['fontname', ['fontname']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['insert', ['link', 'hr']],
			['view', ['fullscreen', 'codeview']],
			['insert', ['picture']]
			//['help', ['help']]
		],
		placeholder:'',
		callbacks: {
			onImageUpload: function(image) {
				uploadImage1(image[0]);
			},
			onKeyup: function(e) {
				clearTimeout(typingTimer1);
				typingTimer1 = setTimeout(doneTypingdescription, doneTypingInterval1);
			},
			onKeydown: function(e) {
				clearTimeout(typingTimer1);
			}
		}
	});
});
function doneTypingdescription () {
	var website_url = '<?php echo Router::url("/admin/news/edit-news-as-draft/",true); ?>';
	$('#saving_draft_description').html('Saving...');
	$.ajax({
		type : 'POST',
		url  : website_url,
		data : $('#login-form').serialize(),
		success : function(response){
			if(response==1)
				$('#saving_draft_description').html('Saved');
			else if(response==0)
				$('#saving_draft_description').html('Some error occured');
			else if(response==2)
				$('#saving_draft_description').html('');
		},
		error : function(){
		}
	});			
	setTimeout(function(){
		$('.draft_msg').html('');
	},3000);
}

$('#category-id').on('change', function(){
	clearTimeout(typingTimer1);
	typingTimer1 = setTimeout(doneTypingcategory, doneTypingInterval1);
});
function doneTypingcategory () {
	var website_url = '<?php echo Router::url("/admin/news/edit-news-as-draft/",true); ?>';
	$('#saving_draft_category').html('Saving...');
	$.ajax({
		type : 'POST',
		url  : website_url,
		data : $('#login-form').serialize(),
		success : function(response){
			if(response==1)
				$('#saving_draft_category').html('Saved');
			else if(response==0)
				$('#saving_draft_category').html('Some error occured');
			else if(response==2)
				$('#saving_draft_category').html('');
		},
		error : function(){
		}
	});			
	setTimeout(function(){
		$('.draft_msg').html('');
	},3000);
}

var $metakeywords = $('#meta-keywords');
$(document).ready(function(){
	$metakeywords.on('keyup', function () {
		clearTimeout(typingTimer1);
		typingTimer1 = setTimeout(doneTypingMetaKeyword, doneTypingInterval1);
	});
	
	$metakeywords.on('keydown', function () {
		clearTimeout(typingTimer1);
	});
});
function doneTypingMetaKeyword () {
	var website_url = '<?php echo Router::url("/admin/news/edit-news-as-draft/",true); ?>';
	$('#saving_draft_meta_keywords').html('Saving...');
	$.ajax({
		type : 'POST',
		url  : website_url,
		data : $('#login-form').serialize(),
		success : function(response){
			if(response==1)
				$('#saving_draft_meta_keywords').html('Saved');
			else if(response==0)
				$('#saving_draft_meta_keywords').html('Some error occured');
			else if(response==2)
				$('#saving_draft_meta_keywords').html('');
		},
		error : function(){
		}
	});			
	setTimeout(function(){
		$('.draft_msg').html('');
	},3000);
}

var $metadescription = $('#meta-description');
$(document).ready(function(){
	$metadescription.on('keyup', function () {
		clearTimeout(typingTimer1);
		typingTimer1 = setTimeout(doneTypingMetaDescription, doneTypingInterval1);
	});
	
	$metadescription.on('keydown', function () {
		clearTimeout(typingTimer1);
	});
});
function doneTypingMetaDescription () {
	var website_url = '<?php echo Router::url("/admin/news/edit-news-as-draft/",true); ?>';
	$('#saving_draft_meta_description').html('Saving...');
	$.ajax({
		type : 'POST',
		url  : website_url,
		data : $('#login-form').serialize(),
		success : function(response){
			if(response==1)
				$('#saving_draft_meta_description').html('Saved');
			else if(response==0)
				$('#saving_draft_meta_description').html('Some error occured');
			else if(response==2)
				$('#saving_draft_meta_description').html('');
		},
		error : function(){
		}
	});			
	setTimeout(function(){
		$('.draft_msg').html('');
	},3000);
}
</script>