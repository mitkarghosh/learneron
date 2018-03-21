<?php
use Cake\Routing\Router;
$session = $this->request->session();
?>
<div class="user-control">
	<div class="user-avatar"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'my-account'),true);?>">
	<?php
	if($header_data['profile_pic'] != ''){
		$image = Router::url("/uploads/user_profile_pic/thumb/", true).$header_data['profile_pic'];
	}else{
		$image = Router::url("/images/", true).'user.png';
	}
	?>
	<img src="<?php echo $image;?>" alt="" id="user_image" />
	</a></div>
	<div class="user-dropdown">
		<div class="btn-group">
			<button type="button" class="btn dropdown-toggle-2" aria-haspopup="true" aria-expanded="false">
				Hi, <?php echo $header_data['name'];?> &nbsp;<i class="fa fa-caret-down"></i>
			</button>
			<ul class="dropdown-menu">
				<li class="dropdown-item"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'my-account'),true);?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
				<li class="dropdown-item"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'edit-profile'),true);?>"><i class="fa fa-edit"></i>Edit Profile</a></li>
				<li class="dropdown-item"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'account-setting'),true);?>"><i class="fa fa-edit"></i>Account Settings</a></li>
				<li class="dropdown-item"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'change-password'),true);?>"><i class="fa fa-lock"></i>Change Password</a></li>
				<li class="dropdown-item"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'logout'),true);?>"><i class="fa fa-power-off"></i>Log Out</a></li>
			</ul>
		</div>
	</div>
</div>
<div class="serach-from">
	<form action="<?php echo Router::url('/questions',true); ?>" method="get">
		<div class="from-row">
			<input value="<?php if($this->request->query('search') !== NULL): echo $this->request->query('search'); endif; ?>" type="text" name="search" placeholder="Keywords" autocomplete="off" />
			<button><i class="fa fa-search" aria-hidden="true"></i></button>
		</div>
	</form>
</div>