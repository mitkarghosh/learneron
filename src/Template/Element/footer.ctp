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
			<input type="hidden" name="website_url" id="website_url" value="<?php echo Router::url('/',true);?>" />
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
<?php
if( empty($get_details) ){
?>
<div class="cookieConcent">
    <div class="cookieConcentInner">
        <div class="cookieText"><?php echo $cookie_data['short_description'];?></div>
        <div class="button-set">
            <a class="active" id="cookie_accept" href="javascript:void(0);">Accept</a>
            <a data-toggle="modal" data-target="#cookie_details" href="javascript:void(0);">Details</a>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="cookie_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Details</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<?php echo $cookie_data['description'];?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-alt" id="cookie_decline" data-dismiss="modal">Cancel</button>
			</div>			
		</div>
	</div>
</div>
<!-- Modal -->
<script>
$('#cookie_accept').click(function(e){
	var status = 'Explicit';
	var website_url = $('#website_url').val();
	$.ajax({
		type: 'POST',
		dataType: 'html',
		data: {status:status},
		url : website_url+'users/cookie_consent',
		success: function(response){
			
		}
	});
});
$('#cookie_decline').click(function(e){
	var status = 'Implicit';
	var website_url = $('#website_url').val();
	$.ajax({
		type: 'POST',
		dataType: 'html',
		data: {status:status},
		url : website_url+'users/cookie_consent',
		success: function(response){
			
		}
	});
});
</script>

<?php
}
?>