<?php
use Cake\Routing\Router;
$session = $this->request->session();
?>
<header class="site-header">
    <div class="header-top">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 logo"><a href="<?php echo Router::url('/', true); ?>"><img src="<?php echo Router::url('/', true); ?>images/logo.png" alt=""></a></div>		  
		  <div class="col-md-8 col-sm-8 header-top-right" id="ajaxlogin">
        <?php
		if(empty($Auth)){
		?>
			<div class="button-set">
				<a <?php if($this->request->params['controller']=='Users' && $this->request->params['action']=='signup'){ echo 'class="active"'; }?> href="<?php echo Router::url('/signup', true);?>">Sign Up</a>
				<a <?php if($this->request->params['controller']=='Users' && $this->request->params['action']=='login'){ echo 'class="active"'; }?> href="<?php echo Router::url('/login', true);?>">Login</a>
			</div>
		<?php
		}else{
			$user_data = $session->read('Auth.Users');
		?>
			<div class="user-control">
				<div class="user-avatar"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'my-account'),true);?>">
				<?php
				if($user_related_details['profile_pic'] != ''){
					$image = Router::url("/uploads/user_profile_pic/thumb/", true).$user_related_details['profile_pic'];
				}else{
					$image = Router::url("/images/", true).'user.png';
				}
				?>
				<img src="<?php echo $image;?>" alt="" id="user_image" />
				</a></div>
				<div class="user-dropdown">
					<div class="btn-group">
						<button type="button" class="btn dropdown-toggle-2" aria-haspopup="true" aria-expanded="false">
							Hi, <?php echo $user_data['name'];?> &nbsp;<i class="fa fa-caret-down"></i>
						</button>
						<ul class="dropdown-menu">
							<li class="dropdown-item"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'my-account'),true);?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
							<li class="dropdown-item"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'edit-profile'),true);?>"><i class="fa fa-edit"></i>Edit Profile</a></li>
							<li class="dropdown-item"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'account-setting'),true);?>"><i class="fa fa-edit"></i>Account Settings</a></li>
						<?php if($user_data['type']=='N'){ ?>
							<li class="dropdown-item"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'change-password'),true);?>"><i class="fa fa-lock"></i>Change Password</a></li>
						<?php } ?>
							<li class="dropdown-item"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'view-submissions'),true);?>"><i class="fa fa-eye"></i>All Submissions</a></li>
							<li class="dropdown-item"><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'logout'),true);?>"><i class="fa fa-power-off"></i>Log Out</a></li>
						</ul>
					</div>
				</div>
            </div>
		<?php
		}
		?>
            <div class="serach-from">
				<form action="<?php echo Router::url('/questions',true); ?>" method="get">
					<div class="from-row">
						<input value="<?php if($this->request->query('search') !== NULL): echo $this->request->query('search'); endif; ?>" type="text" name="search" placeholder="Keywords" autocomplete="off" />
						<button><i class="fa fa-search" aria-hidden="true"></i></button>
					</div>
				</form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header-mid">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-8 col-3 nav-container"> <a href="javascript:void(0);" class="mob-menu"> <i class="fa fa-bars"></i> </a>
            <nav class="site-nav">
              <a href="javascript:void(0);" class="menu-close"><i class="fa fa-close"></i></a>
              <ul class="menu">
                <li <?php if($this->request->params['controller']=='Sites' && ($this->request->params['action']=='homePage' || $this->request->params['action']=='mostViewed' || $this->request->params['action']=='unAnswered')){ echo 'class="active"'; }?>><a href="<?php echo Router::url('/', true); ?>">Home</a></li>
                <li <?php if($this->request->params['controller']=='Questions' && $this->request->params['action']=='postQuestion'){ echo 'class="active"'; }?>><a href="<?php echo Router::url('/post-question', true); ?>">Ask Questions</a></li>
                <li <?php if($this->request->params['controller']=='Questions' && ($this->request->params['action']=='allQuestions' || $this->request->params['action']=='mostViewedQuestions' || $this->request->params['action']=='unAnsweredQuestions')){ echo 'class="active"'; }?>><a href="<?php echo Router::url('/questions', true); ?>">Browse All Questions</a></li>
                <li <?php if($this->request->params['controller']=='Tags' && $this->request->params['action']=='index'){ echo 'class="active"'; }?>><a href="<?php echo Router::url('/tags', true); ?>">Tags</a></li>
                <li <?php if($this->request->params['controller']=='Users' && ($this->request->params['action']=='allUsers' || $this->request->params['action']=='myAccount')){ echo 'class="active"'; }?>><a href="<?php echo Router::url('/users', true); ?>">Users</a></li>
                <li <?php if($this->request->params['controller']=='News'){ echo 'class="active"'; }?>><a href="<?php echo Router::url('/news', true); ?>">News & Views</a></li>
                <li <?php if($this->request->params['controller']=='Sites' && $this->request->params['action']=='aboutUs'){ echo 'class="active"'; }?>><a href="<?php echo Router::url('/about-us', true); ?>">About Us</a></li>
              </ul>
            </nav>
          </div>
          <div class="col-md-4 col-sm-4 col-9 col social-menu-container">
            <!--<ul>
				<li><a href="<?php echo $site_settings->facebook_link;?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
				<li><a href="<?php echo $site_settings->twitter_link;?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
				<li><a href="<?php echo $site_settings-> google_plus_link;?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
				<li><a href="<?php echo $site_settings->linkedin;?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
            </ul>-->
			<div class="sharethis-inline-share-buttons"></div>
          </div>
        </div>
      </div>
    </div>
</header>