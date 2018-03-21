<?php use Cake\Routing\Router; ?>
<?php
if(!empty($all_comments)){
?>
		<ul>
<?php	foreach($all_comments as $comemnt){	?>
			<li>												 
				<div class="comment-avatar">
					<figure>
				<?php
				if(empty($comemnt['user'])):
				?>
						<img src="<?php echo Router::url('/images/user_small.png');?>" alt="" class="img_user" />
				<?php
				else:
					if($comemnt['user']['profile_pic'] != ''):
				?>
						<img src="<?php echo Router::url('/uploads/user_profile_pic/thumb/').$comemnt['user']['profile_pic'];?>" alt="<?php echo $comemnt['user']['name'];?>" class="img_user" />
				<?php
					else:
				?>
						<img src="<?php echo Router::url('/images/user_small.png');?>" alt="<?php echo $comemnt['user']['name'];?>" class="img_user" />
				<?php
					endif;
				endif;
				?>
					</figure>
				</div>												 
				<div class="comment">
					<p><?php echo $comemnt['comment'];?></p>
					<div>
						<div class="comment-meta">
							<i class="fa fa-user"></i>
							BY <?php if(empty($comemnt['user']))echo $comemnt['name']; else echo $comemnt['user']['name'];?>
						</div>
						<div class="comment-meta">
							<i class="fa fa-calendar-o"></i> On <?php echo date('jS F Y', strtotime($comemnt['created']));?>
						</div>
					</div>
				</div>
			</li>
<?php	} ?>
		</ul>
<?php
}
?>
<?php if(!empty($all_comments)){ ?>
	<div class="loader">
		<?php echo $this->Paginator->next('Load more'); ?>
	</div>	
<?php } ?>