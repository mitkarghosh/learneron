<?php use Cake\Routing\Router; ?>
<?php
if(!empty($all_comments)){
?>
	<div class="comment-sec">
		<div class="post-comment question-comment">
			<div class="comment-list">
				<ul>
	<?php
				foreach($all_comments as $ans_com){
	?>
					<li>
						<div class="comment-avatar">
							<figure>
							<?php
							if(empty($ans_com->user)):
							?>
								<figure><img src="<?php echo Router::url('/images/user_small.png');?>" alt="" class="img_user" /></figure>
							<?php
							else:
								if($ans_com->user->profile_pic != ''):
							?>
								<figure><img src="<?php echo Router::url('/uploads/user_profile_pic/thumb/').$ans_com->user->profile_pic;?>" alt="<?php echo $ans_com->user->name;?>" class="img_user" /></figure>
							<?php
								else:
							?>
								<figure><img src="<?php echo Router::url('/images/user_small.png');?>" alt="<?php echo $ans_com->user->name;?>" class="img_user" /></figure>
							<?php
								endif;
							endif;
							?>
							</figure>
						</div>
						<div class="comment">
							<p><?php echo $ans_com->comment;?></p>
							<div>
								<div class="comment-meta"> By <?php echo $ans_com->user->name;?></div>
								<div class="comment-meta"> On <?php echo date('jS F Y', strtotime($ans_com->created));?></div>
							</div>
						</div>
					</li>
	<?php
				}
	?>
				</ul>
			</div>						
		</div>						
	</div>
<?php
}else{
	echo 'No records found.';
}
?>