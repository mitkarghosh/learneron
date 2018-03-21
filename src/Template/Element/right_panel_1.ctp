<?php
use Cake\Routing\Router;
if(!empty($question_categories)){
?>
<div class="category side-bar-block">
	<h3>Browse By Category</h3>
	<div class="side-bar-block-box">
		<ul>
<?php foreach($question_categories as $key_categories => $val_categories){ ?>
			<li class="<?php if(substr_count($val_categories,'*')==1)echo ' leftmargin_first';elseif(substr_count($val_categories,'*')==2)echo ' leftmargin_second';elseif(substr_count($val_categories,'*')==3)echo ' leftmargin_third';?>">
				<a href="<?php echo $this->Url->build(['controller'=>'Questions','action'=>'question-category',$key_categories]);?>">
					<span><?php echo str_replace('*','',$val_categories);?></span>
				</a>
			</li>
<?php } ?>
		</ul>
	</div>
</div>
<?php
}
if(!empty($featured_question_rightpanel)){
?>
<div class="feature side-bar-block">
	<h3>Featured Questions</h3>
	<div class="side-bar-block-box">
		<ul>
<?php foreach($featured_question_rightpanel as $question){ ?>
			<li>
				<a href="<?php echo $this->Url->build(['controller'=>'Questions','action'=>'details',base64_encode($question->id)]);?>">
				<?php
				if(empty($question->user)):
				?>
					<figure><img src="<?php echo Router::url('/images/user_small.png');?>" alt="" /></figure>
				<?php
				else:
					if($question->user->profile_pic != ''){
						$image = Router::url("/uploads/user_profile_pic/thumb/", true).$question->user->profile_pic;
					}else{
						$image = Router::url("/images/", true).'user.png';
					}
				?>
					<figure><img src="<?php echo $image;?>" alt="<?php echo $question->user->name;?>" /></figure>
				<?php				
				endif;
				?>
					<span><?php echo $question->name;?></span>
				</a>
			</li>
<?php
	}
?>
		</ul>
	</div>
</div>
<?php
}
if(!empty($recently_most_viewed_questions)){
?>
<div class="feature side-bar-block">
	<h3>Recently Most Viewed Questions</h3>
	<div class="side-bar-block-box">
		<ul>
<?php foreach($recently_most_viewed_questions as $question){ ?>
			<li>
				<a href="<?php echo $this->Url->build(['controller'=>'Questions','action'=>'details',base64_encode($question->id)]);?>">
				<?php
				if(empty($question->user)):
				?>
					<figure><img src="<?php echo Router::url('/images/user_small.png');?>" alt="" /></figure>
				<?php
				else:
					if($question->user->profile_pic != ''):
				?>
					<figure><img src="<?php echo Router::url('/uploads/user_profile_pic/thumb/').$question->user->profile_pic;?>" alt="<?php echo $question->user->name;?>" /></figure>
				<?php
					else:
				?>
					<figure><img src="<?php echo Router::url('/images/user_small.png');?>" alt="<?php echo $question->user->name;?>" /></figure>
				<?php
					endif;
				endif;
				?>
					<span><?php echo $question->name;?></span>
				</a>
			</li>
<?php
	}
?>
		</ul>
	</div>
</div>
<?php
}
if(!empty($latest_news_rightpanel)){
?>
<div class="recent side-bar-block">
	<h3>Latest News & Views</h3>
	<div class="side-bar-block-box">
		<ul>
<?php foreach($latest_news_rightpanel as $news){ ?>
			<li>
				<a href="<?php echo $this->Url->build(['controller'=>'News','action'=>'details',$news->slug]);?>">
			<?php if($news->image !=  ''): ?>
					<img src="<?php echo Router::url('/uploads/news/thumb/').$news->image;?>" alt="<?php echo $news->name;?>" />
			<?php else: ?>
					<img src="<?php echo Router::url('/images/no_image_small.png');?>" alt="<?php echo $news->name;?>" />
			<?php endif; ?>
				</a>
				<div class="questions-dtls">
					<a href="<?php echo $this->Url->build(['controller'=>'News','action'=>'details',$news->slug]);?>"><?php echo $news->name;?></a>
					<p><?php echo strip_tags(substr($news->description,0,100));?></p>
					<div class="questions-dtls-info clearfix">
						<div> <i class="fa fa-calendar-o"></i><?php echo date('jS M Y',strtotime($news->created));?></div>
						<div> <i class="fa fa-user"></i>By <?php if(empty($news->user)){echo 'Admin';}else{echo $news->user->name;}?></div>
					</div>
				</div>
			</li>
<?php
		}
?>
		</ul>
	</div>
</div>
<?php
}
?>