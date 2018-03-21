<?php use Cake\Routing\Router; ?>
<footer class="site-footer">
    <div class="conatiner">
		<div class="social-menu-container">
			<!--<ul>
				<li><a href="<?php echo $site_settings->facebook_link;?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
				<li><a href="<?php echo $site_settings->twitter_link;?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
				<li><a href="<?php echo $site_settings-> google_plus_link;?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
				<li><a href="<?php echo $site_settings->linkedin;?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
			</ul>-->
			<div class="sharethis-inline-share-buttons"></div>
		</div>
		<div class="footer-nav">
			<ul>
				<li style="text-transform:none;"><a href="<?php echo Router::url('/terms-of-use', true); ?>">Terms of Use</a></li>
				<li><a href="<?php echo Router::url('/privacy', true); ?>">Privacy</a></li>
				<li><a href="<?php echo Router::url('/contact-us', true); ?>">Contact Us</a></li>
				<li><a href="<?php echo Router::url('/faqs', true); ?>">FAQs</a></li>
			<?php if(empty($Auth)){ ?>
				<li><a href="<?php echo Router::url('/signup', true); ?>">Sign Up</a></li>
				<li><a href="<?php echo Router::url('/login', true); ?>">Login</a></li>
			<?php }else{ ?>
				<li><a href="<?php echo Router::url(array('controller'=>'Users','action'=>'logout'),true);?>">Logout</a></li>
			<?php } ?>
			</ul>
		</div>
		<p class="copy">&copy;<?php echo date('Y');?>  Copyright LearnerOn | Powered By : <a href="http://www.techtimes-in.com/" target="_blank">TechTimes</a></p>
	</div>
</footer>