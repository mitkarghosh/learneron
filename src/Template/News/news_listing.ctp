<?php use Cake\Routing\Router; ?>
<div class="genpage-user-system">
	<?php echo $this->element('advertisement'); ?>
    <div class="container">      
		<section class="top-question-section">
			<div class="container">
				<div class="row">
					<div class="col-md-9 col-sm-8">
						<div class="title">
							<h1><?php echo $cms_data->title; ?></h1>
						</div>           
						<div class="news-wrapper">
							<p><?php echo $cms_data->description; ?></p>            	
							<div class="news-listing" id="news_listing">
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
												<span><i class="fa fa-eye" aria-hidden="true"></i><?php echo count($news->news_comment);?></span>
											</div>
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
										<br> On <?php echo date('jS M Y',strtotime($news->created));?></p>
									</div>
								</div>
						<?php
							}
						}else{
							echo '<p class="no_results_found">No results found</p>';
						}
						?>
							</div>
            	
						<?php if(!empty($all_news)){ ?>
							<div class="loader">
								<?php echo $this->Paginator->next('Load more'); ?>
							</div>	
						<?php } ?>
							<br><br>           	
							<div class="follow-us">
								<?php echo $this->element('follow_us');?>
							</div>            	
						</div>
					</div>
					<div class="col-md-3 col-sm-4 question-right ">
						<?php echo $this->element('right_panel_news');?>
					</div>
				</div>
			</div>
		</section>
    </div>
</div>
<form id="search_form1">
  <input type="hidden" name="main_cat" value="" id="main_cat">
</form>
<script>
jQuery(function(){
	$(document).on('click', 'a[rel="next"]', function() {
		$('.next').remove();
		$('.loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var target = $(this).attr('href').replace("news-listing","search");
		var data = $('#search_form1').serialize();
		if(!target)
			return false;
		$.post(target, data, function(data) {
			$('.loader').remove();
			var e1 = jQuery(data);
			$('.next').remove();
			$('#news_listing').append(e1).masonry('appended', e1, true);
			//$('#news_listing').append( data );
		}, 'html');
		return false;
	});
});
</script>