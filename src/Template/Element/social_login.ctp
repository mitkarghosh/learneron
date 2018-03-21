<?php
use Cake\Routing\Router;
?>
<script>
/*Login with Google start here*/
function login_with_google(){
	window.location.href = "<?php echo Router::url('/', true) ?>users/googleLogin";  
}
/*Login with Google end here*/

/*Login with Twitter start here*/
function login_with_twitter(){
	window.location.href="<?php echo Router::url('/', true) ?>users/twitterLogin";  
}
/*Login with Twitter end here*/

/*Login with Linkedin start here*/
function login_with_linkedin(){
	window.location.href="<?php echo Router::url('/', true) ?>users/linkedinLogin";
}
/*Login with Linkedin end here*/
</script>