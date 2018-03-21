<?php use Cake\Routing\Router; ?>
<?php
if(!empty($all_users)){
	foreach($all_users as $user){
?>
		<div class="col-md-4 col-sm-12">								
			<div class="user-block">
				<figure class="user-pic">
					<!--<a href="#">-->
					<?php
					if($user->profile_pic != ''):
					?>
					<img src="<?php echo Router::url('/uploads/user_profile_pic/thumb/').$user->profile_pic;?>" alt="<?php echo $user->name;?>" />
					<?php
					else:
					?>
					<img src="<?php echo Router::url('/images/user_small.png');?>" alt="<?php echo $user->name;?>" />
					<?php
					endif;
					?>
					<!--</a>-->
				</figure>
				<div class="user-detials">
					<h5><a href="javascript:void(0);" onclick="return get_user_public_details('<?php echo $user->id;?>');"><?php echo $user->name;?></a></h5>
					<span class="user-address"><?php echo $user->location;?>&nbsp;</span>
					<div class="user-activities">
						<a href="javascript:void(0);" title="questions asked"><i class="fa fa-question-circle"></i><?php if(!empty($user->questions)): echo count($user->questions);else: echo 0; endif;?></a>
						<a href="javascript:void(0);" title="answers provided"><i class="fa fa-reply"></i><?php if(!empty($user->question_answer)): echo count($user->question_answer);else: echo 0; endif;?></a>
					</div>
					<span id="user_loader_<?php echo $user->id;?>"></span>
				</div>
			</div>
		</div>
<?php
	}
}
?>
<?php if(!empty($all_users)){ ?>
	<div class="loader">
		<?php echo $this->Paginator->next('Load more'); ?>
	</div>	
<?php } ?>