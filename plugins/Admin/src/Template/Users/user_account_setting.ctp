<?php
use Cake\Routing\Router;
$response_to_my_question_notification = ''; $news_notification = ''; $follow_twitter = ''; $posting_new_question_notification = ''; $category_id = '';
if(isset($existing_account_settings) && $existing_account_settings['response_to_my_question_notification']==1){
	$response_to_my_question_notification = 'checked';
}
if(isset($existing_account_settings) && $existing_account_settings['news_notification']==1){
	$news_notification = 'checked';
}
if(isset($existing_account_settings) && $existing_account_settings['follow_twitter']==1){
	$follow_twitter = 'checked';
}
if(isset($existing_account_settings) && $existing_account_settings['posting_new_question_notification']==1){
	$posting_new_question_notification = 'checked';
}
if(isset($existing_account_settings) && $existing_account_settings['category_id'] != ''){
	$category_id = $existing_account_settings['category_id'];
}
?>
<style>
.checkbox{display:block;}
.education_width, .career_width{width:49% !important;}
.education_margin, .career_margin{margin-right:5px !important;}
.social_class{padding-left:0;}
.more-files1{border:1px solid #ccc; margin-bottom:0 !important;}
.more-files1:hover{color:#caa961; border:1px solid #caa961; margin-bottom:0 !important;}
.remove_minus{position:absolute; top:9px; right:0; padding-right:2px;cursor:pointer; color:#db0e1e;}
</style>
<article class="content item-editor-page">
   <div class="title-block">
      <h3 class="title">
         Edit Account Setting
         <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <?php echo $this->Flash->render() ?>
   <?php echo $this->Form->create($existing_account_settings,['id' => 'login-form', 'novalidate' => 'novalidate', 'enctype'=>'multipart/form-data']); ?>
      <div class="card card-block">
		<div class="form-group row">
            <label class="col-sm-4 form-control-label text-xs-right">Primary Email:</label>
            <div class="col-sm-8">
				<?php echo $existing_account_settings['user']['email'];?>
            </div>
        </div>		
		<div class="form-group row">
            <label class="col-sm-4 form-control-label text-xs-right">Notification Email:</label>
            <div class="col-sm-8">
				<?php if($existing_account_settings['user']['notification_email'] != ''){ ?>
					<span style="<?php if($existing_account_settings['user']['notification_email'] != '')echo 'display:block';else echo 'dislay:none';?>">
						<input type="text" id="notification_email" name="notification_email" value="<?php echo $existing_account_settings['user']['notification_email'];?>" class="form-control boxed" />
					</span>
				<?php }else{ ?>
					<span style="<?php if($existing_account_settings['user']['notification_email'] != '')echo 'display:block';else echo 'dislay:none';?>">
					<input type="text" id="notification_email" name="notification_email" value="<?php echo $existing_account_settings['user']['email'];?>" class="form-control boxed" />
				</span>
				<?php } ?>
            </div>
        </div>
		<div class="form-group row">
            <label class="col-sm-4 form-control-label text-xs-right">Receive email notifications on new responses to my questions:</label>
            <div class="col-sm-8">
				<input type="checkbox" id="response_to_my_question_notification" name="response_to_my_question_notification" value="1" <?php echo $response_to_my_question_notification;?> />
            </div>
        </div>
		<div class="form-group row">
            <label class="col-sm-4 form-control-label text-xs-right">Subscribe for News & Views:</label>
            <div class="col-sm-8">
				<input type="checkbox" id="news_notification" name="news_notification" value="1" <?php echo $news_notification;?> />
            </div>
        </div>
		<div class="form-group row">
            <label class="col-sm-4 form-control-label text-xs-right">Follow us on Twitter:</label>
            <div class="col-sm-8">
				<input type="checkbox" id="follow_twitter" name="follow_twitter" value="1" <?php echo $follow_twitter;?> />
            </div>
        </div>
		<div class="form-group row">
            <label class="col-sm-4 form-control-label text-xs-right">Send me notifications on posting new question in below defined categories:</label>
            <div class="col-sm-6">
				<input type="checkbox" id="posting_new_question_notification" name="posting_new_question_notification" value="1" <?php echo $posting_new_question_notification;?> /><br /><br />
				<select name="category_id" id="category_id" class="form-control boxed">
					<option value="" disabled selected>Select your categories</option>
					<option value="">Select Catagory</option>
			<?php
			if(!empty($question_categories)){
				foreach($question_categories as $key_cat => $val_cat){
			?>
					<option value="<?php echo $key_cat;?>" <?php if($key_cat==$category_id){echo 'selected';}?>><?php echo $val_cat;?></option>
			<?php
				}
			}
			?>
				</select>
            </div>
        </div>
		 
		<div class="form-group row">
            <div class="form-group row">
				<label class="col-sm-4 form-control-label text-xs-right">&nbsp;</label>
				<div class="col-sm-6">
				   <?php echo $this->Form->button('Update',['type' => 'submit','class' => 'btn btn-primary']); ?>&nbsp;
				<a href="<?php echo Router::url('/admin/users/list-data',true); ?>" class="btn btn-primary">Cancel</a>
				</div>
			</div>
      </div>
   <?php echo $this->Form->end(); ?>
</article>