<?php use Cake\Routing\Router; ?>
<?php
if(!empty($all_news)){
	foreach($all_news as $news){
?>
		<div class="news-item">
			<div class="thumbnail">
				<?php if($news->image != ''): ?>
					<img src="<?php echo Router::url('/uploads/news/thumb/').$news->image; ?>" alt="<?php echo $news->name;?>" />
				<?php else: ?>
					<img src="<?php echo Router::url('/images/no_image_small.png');?>" alt="<?php echo $news->name;?>" />
				<?php endif; ?>
				<div class="hover-content">
					<div>
						<span><i class="fa fa-comments-o" aria-hidden="true"></i>
						<?php if($news->view != '' || $news->view != NULL)echo $news->view; else echo 0;?>
						</span>
					<span><i class="fa fa-eye" aria-hidden="true"></i><?php echo count($news->news_comment);?></span></div>
				</div>
			</div>
			<div class="details">
				<a href="<?php echo Router::url(array('controller'=>'News','action'=>'details/'.$news->slug, false));?>"><?php echo $news->name;?></a>
				<span class="category">
				<?php
				if(!empty($news->news_category->ParentCategory)){
					echo $news->news_category->ParentCategory->name.' / ';
				}
				echo $news->news_category->name;
				?>
				</span>										
				<p><?php echo strip_tags(substr($news->description,0,80));?></p>
			</div>
			<div class="info">
				<p>Posted By 
				<?php
				if(empty($news->user)){
					echo 'Admin';
				}else{
					echo $news->user->name;
				}
				?>				
				<br> On <?php echo date('jS M Y',strtotime($news->created)); ?></p>
			</div>
		</div>
<?php
	}
}
?>
<?php if(!empty($all_news)){ ?>
	<div class="loader">
		<?php echo $this->Paginator->next('Load more'); ?>
	</div>	
<?php } ?>