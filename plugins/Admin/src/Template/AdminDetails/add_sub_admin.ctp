<?php use Cake\Routing\Router; $session = $this->request->session(); ?>
<style>
.prm-title {background: #888687 none repeat scroll 0 0; border: 0 solid #d0c7c8; color: #fff; float: left; font-size: 12px; font-weight: bold; padding: 2px 13px; width: 100%;}
.prm-detail { background: #d5e2bd none repeat scroll 0 0; border: 1px solid #d0c7c8; float: left; padding: 20px 15px; width: 100%; }
.prm-detail .chk-box {float: left; margin-bottom: 15px; width: 25%; }
.prm-detail input.ace[type="checkbox"] {margin-right: 5px !important;}
.form-horizontal {.control-label {text-align: left;}}
.rtl .form-horizontal .control-label {text-align: left;}
.form-horizontal .control-label, .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline { padding-top: 7px; margin-top: 0; margin-bottom: 0;}
.form-horizontal .form-group {margin-right: -12px; margin-left: -12px;}
.form-horizontal .form-group:before, .form-horizontal .form-group:after { display: table; content: " ";}
.form-horizontal .form-group:after {clear: both;}
.form-horizontal .form-group:before, .form-horizontal .form-group:after { display: table; content: " ";}
.form-horizontal .form-group:after {clear: both;}
@media (min-width: 768px) {.form-horizontal .control-label {text-align: right;}}
</style>
<article class="content item-editor-page">
	<div class="title-block">
		<h3 class="title">
			Add Sub Admin
			<span class="sparkline bar" data-type="bar"></span>
		</h3>
	</div>
	<?php echo $this->Flash->render() ?>
	<?php echo $this->Form->create($user,['id' => 'login-form', 'novalidate' => 'novalidate', 'id'=>'MemberEditForm', 'enctype'=>'multipart/form-data']); ?>
	<div class="card card-block">
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">
				First Name:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('first_name', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'First Name']); ?>
            </div>
        </div>
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Last Name:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('last_name', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Last Name']); ?>
            </div>
        </div>
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Email:</span>
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('email', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Email Address']); ?>
            </div>
        </div>
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Password:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('password', ['type' => 'password', 'required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Password']); ?>
            </div>
        </div>
		<div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
               Confirm Password:
            </label>
            <div class="col-sm-10">
               <?php echo $this->Form->input('confirm_password', ['type' => 'password', 'required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Confirm Password']); ?>
            </div>
        </div>
	<?php if( (array_key_exists('change-status-subadmin',$session->read('permissions.'.strtolower('AdminDetails')))) && $session->read('permissions.'.strtolower('AdminDetails').'.'.strtolower('change-status-subadmin'))==1 ){ ?>
		<div class="form-group row">
			<label class="col-sm-2 form-control-label text-xs-right">Status:</label>
			<div class="col-sm-2">
				<?php echo $this->Form->input('status', ['required' => true, 'label' => false, 'class' => 'form-control boxed', 'placeholder' => 'Status', 'options' => ['A' => 'Active', 'I' => 'Inactive']]); ?>
			</div>
		</div>
	<?php } ?>	
		<hr />
		<div>
			<div class="title-block">
				<h3 class="title">
					Permissions
					<span class="sparkline bar" data-type="bar"></span>
				</h3>
			</div>
			<?php foreach($menus as $main_menu){ ?>
			<div class="prm-title">
				<span class="lbl lbl1"> <?php echo $main_menu->main_menu_name; ?></span>
			</div>
			<?php
				if(!empty($main_menu->Methods)){
					?>
			<div class="prm-detail">
			<?php
			foreach($main_menu->Methods as $method) {
				if($method->method_name != ''){
			?>
				<div class="chk-box">
				<input class="ace checkbox_<?php echo strtolower($method->controller_name);?>" type="checkbox" name="admin_permisions[][admin_menu_id]" value="<?php echo $method->id;?>" id="<?php echo strtolower($method->menu_name).'_'.strtolower($method->controller_name);?>" data-controller="<?php echo strtolower($method->controller_name);?>" data-method="<?php echo strtolower($method->menu_name);?>" onclick="function_checked('<?php echo strtolower($method->menu_name);?>','<?php echo $method->id;?>','<?php echo strtolower($method->controller_name);?>');">
				<span class="lbl"> <?php echo $method->menu_name_modified; ?></span>
				</div>
			<?php
				}
			}
			}
			?>
				</div>
				<div class="clear">&nbsp;</div>
				<?php
			} ?>
			<div class="space-4"></div>
		</div>
		
		
		<div class="form-group row">
			<div class="col-sm-10 col-sm-offset-2">
			   <?php echo $this->Form->button('Add',['type' => 'submit','class' => 'btn btn-primary']); ?>&nbsp;
				<a href="<?php echo Router::url('/admin/admin-details/list-sub-admin',true); ?>" class="btn btn-primary">Cancel</a>
			</div>
		</div>
	</div>
   <?php echo $this->Form->end(); ?>
</article>
<script type="text/javascript">
$("#MemberEditForm").validate({
	rules:{
		password:{
			minlength: 6
		},
		confirm_password:{
			equalTo: password
		}
	}
});

function function_checked(method, menuid, controller){
	if($('#'+method+'_'+controller).is(":checked")){
		var checked_method = $('#'+method+'_'+controller).data("method");
		if(checked_method != 'view'){
			$('#view_'+controller).prop('checked', true);
		}
	}else{
		var unchecked_method = $('#'+method+'_'+controller).data("method");
		if(unchecked_method == 'view'){
			$('.checkbox_'+controller).prop('checked', false);
		}
	}
}
</script>