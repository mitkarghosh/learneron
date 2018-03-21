<?php
use Cake\Routing\Router;
$session  = $this->request->session();
if(!empty($user_details)){
?>
<div class="genpage-user-system">
    <div class="container">
		<div class="title prof_title">
			<h1>User Profile</h1>
		</div>
		<div class="genpage-wrapper">
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<div class="user-profile-photo">
					<?php
					if($user_details['profile_pic'] != ''){
						$image = Router::url("/uploads/user_profile_pic/thumb/", true).$user_details['profile_pic'];
					}else{
						$image = Router::url("/images/", true).'user.png';
					}
					?>
						<figure><img src="<?php echo $image; ?>" alt="" id='img_to_show' /></figure>											
					</div>
				</div>
				<div class="col-md-8 col-sm-8">
					<div class="user-profile-details">              
						<div class="edit-details-wrapper">                
							<div class="about-user-row maginless_user_row">								
								<h3>Public Information</h3>
							<?php
							if($user_details['name'] != ''){
							?>
								<h5>Name or Nick Name: <span class="user_details"><?php echo $user_details['name'];?></span></h5>
							<?php
							}
							if($user_details['location'] != ''){
							?>
								<h5>Location: <span class="user_details"><?php echo $user_details['location'];?></span></h5>								
							<?php
							}
							if($user_details['title'] != ''){
							?>
								<h5>Title: <span class="user_details"><?php echo $user_details['title'];?></span></h5>
							<?php
							}
							if($user_details['about_me'] != ''){							
							?>
								<h5>About Me: <span class="user_details"><?php echo $user_details['about_me'];?></span></h5>
							<?php
							}
							?>
							</div>
							<?php
							if($user_details['facebook_link'] != '' || $user_details['twitter_link'] != '' || $user_details['gplus_link'] != '' || $user_details['linkedin_link'] != ''){
							?>
							<div class="about-user-row maginless_user_row">
								<h3>Web Preference</h3>
								<div class="row">
								<?php 
								if($user_details['twitter_link'] != ''){
								?>
									<div class="col-md-6">
										<h5>Twitter Link</h5>
										<a href="<?php echo $user_details['twitter_link'];?>"><?php echo $user_details['twitter_link'];?></a>
									</div>
								<?php 
								}
								if($user_details['facebook_link'] != ''){
								?>
									<div class="col-md-6">
										<h5>Facebook Link</h5>
										<a href="<?php echo $user_details['facebook_link'];?>"><?php echo $user_details['facebook_link'];?></a>
									</div>
								<?php
								}
								if($user_details['gplus_link'] != ''){
								?>
									<div class="col-md-6">
										<h5>Google Plus Link</h5>
										<a href="<?php echo $user_details['gplus_link'];?>"><?php echo $user_details['gplus_link'];?></a>
									</div>
								<?php
								}
								if($user_details['linkedin_link'] != ''){
								?>
									<div class="col-md-6">
										<h5>Linkedin Link</h5>
										<a href="<?php echo $user_details['linkedin_link'];?>"><?php echo $user_details['linkedin_link'];?></a>
									</div>
								<?php
								}
								?>
								</div>
							</div>
							<?php
							}
							if(!empty($user_details['careereducations'])){
							?>
							<div class="about-user-row maginless_user_row">
								<h3>Career & Education History</h3>
							<?php
								$e=0; $c=0;
								foreach($user_details['careereducations'] as $ca){
									if($ca['history_type']=='E'){
							?>
										<div class="row">
							<?php 		if($e==0){ ?>
											<div class="col-md-12">
												<p>Education</p>
											</div>
							<?php		} ?>
											<div class="col-md-6">
							<?php 		if($e==0){ ?>
												<h5>Educational Details</h5>
							<?php		} ?>
												<p><?php echo @$ca['edu_degree'];?> At <?php echo @$ca['edu_organization'];?></p>
											</div>
											<div class="col-md-6">
							<?php 		if($e==0){ ?>
												<h5>Time Period</h5>
							<?php		} ?>
												<p>From <?php echo date('jS F Y',strtotime($ca['edu_from']));?> To <?php echo date('jS F Y',strtotime($ca['edu_to']));?></p>
											</div>									
										</div>
							<?php
									$e++;
									}
									else if($ca['history_type']=='C'){
							?>
										<div class="row">
							<?php 		if($c==0){ ?>
											<div class="col-md-12">
												<p>Work</p>
											</div>
							<?php		} ?>
											<div class="col-md-6">
							<?php 		if($c==0){ ?>
												<h5>Company Details</h5>
							<?php		} ?>
												<p><?php echo @$ca['career_position'];?> At <?php echo @$ca['career_company'];?></p>
											</div>
											<div class="col-md-6">
							<?php 		if($c==0){ ?>
												<h5>Time Period</h5>
							<?php		} ?>
												<p>From <?php echo date('jS F Y',strtotime($ca['career_from']));?> To <?php echo date('jS F Y',strtotime($ca['career_to']));?></p>
											</div>									
										</div>
							<?php
									$c++;
									}
								}
							?>
							</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}else{
	echo 'No results found.';
}
?>