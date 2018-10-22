<?php use Cake\Routing\Router; $session = $this->request->session();?>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Edit Banner
         <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <?php echo $this->Flash->render() ?>
   <?php echo $this->Form->create($existing_bannerSections,['id' => 'banner_form', 'novalidate' => 'novalidate', 'enctype'=>'multipart/form-data']); ?>
      <div class="card card-block">
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Title:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('title', ['required' => false, 'id' =>'banner_title', 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Banner Title' ]); ?>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
              Sub Title 1:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('sub_title', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Sub Title 1' ]); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Link 1:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('link', ['required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Banner Link 1' ]); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Link 1 Text:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('link_text', ['type' => 'text', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Banner Link 1 Text' ]); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Link 2:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('link2', ['required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Banner Link 2' ]); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Link 2 Text:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('link2_text', ['type' => 'text', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Banner Link 2 Text' ]); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
              Sub Title 2:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('sub_title2', ['type'=>'textarea', 'required' => false, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Sub Title 2' ]); ?>
            </div>
         </div>
		 <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
              Sub Title Mobile:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('sub_title_mobile', ['type'=>'textarea', 'required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Sub Title Mobile', 'maxlength' => 85 ]); ?>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Banner Image:
            </label>
            <div class="col-sm-10">
				<?php echo $this->Form->input('image', ['type'=>'file', 'required' => true, 'label' => false, 'class' => 'form-control boxed', 'accept'=>"image/*", 'onchange' => 'image_preview(event)', 'autocomplete' => 'off']); ?>
				<p class="error_msg"></p>
				<p class="sm_txt_nm">* Please upload jpg, png, jpeg files only, for best view please add above 1336px x 343px image.</p>
				<?php
				$image = '';
				if($existing_bannerSections->image !=''){
					$image = $existing_bannerSections->image;
					$image = Router::url('/uploads/banner/thumb/', true).$image;
				}
				?>
				<span id="pro_pic">
				<?php if($existing_bannerSections->image !=''){ ?>
					<img src="<?php echo $image; ?>" width='150' height='75' style="border:1px solid #000; padding:5px;" />
				<?php } ?>
				</span>
				<output id='image_view' style="padding-top:0px;"></output>
            </div>
         </div>
		<?php
		if( (array_key_exists('change-status',$session->read('permissions.'.strtolower('BannerSections')))) && $session->read('permissions.'.strtolower('BannerSections').'.'.strtolower('change-status'))==1 ){
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
               <?php echo $this->Form->button('Update',['type' => 'submit','class' => 'btn btn-primary']); ?>&nbsp;
				<a href="<?php echo Router::url('/admin/banner-sections/list-data',true); ?>" class="btn btn-primary">Cancel</a>
            </div>
         </div>
      </div>
   <?php echo $this->Form->end(); ?>
</article>
<script type="text/javascript">
/*$('#banner_form').validate({
      rules: {
        title:{
          required: true,
          minlength: 3,
          maxlength:20
        },
        sub_title:{
          required: true,
          minlength: 3,
          maxlength:150
        }
      }
    });*/
var _URL = window.URL || window.webkitURL;
   $('#image').change(function(){
       var file_name = $('#image').val();
       var file_name_arr = file_name.split(/[\s.]+/);
       var ext = file_name_arr[file_name_arr.length-1].toLowerCase();
       if(ext != 'jpg' && ext != 'png' && ext != 'jpeg' && ext != 'bmp' && ext != 'gif'){
         $('.error_msg').html('Please upload image file only').css({'color':'red'});
         $('#image').val('');
         return false;
       }else{
         $('.error_msg').html('');
       }
       var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                if(this.width<1400 || this.height<464){
                  $('.error_msg').html('Image size must be above 1400 x 464px, your image size is: '+this.width + "px x " + this.height+'px').css({'color':'red'});
                   $('#image').val('');
                   return false;
                }else{
                  $('.error_msg').html('');
                }
            };
            img.src = _URL.createObjectURL(file);
        }
     });
</script>