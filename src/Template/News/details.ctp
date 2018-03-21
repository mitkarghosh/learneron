<?php use Cake\Routing\Router; ?>
<div class="genpage-user-system bg-white">
    <div class="container">      
		<section class="top-question-section">
			<div class="container">
				<div class="row">
					<div class="col-md-9 col-sm-8">
						<div class="title">
							<h1>News Details</h1>
						</div>           
						<div class="news-wrapper">
							<div class="news-thumb">
							<?php if($news_detail['image'] != ''): ?>
								<img src="<?php echo Router::url('/uploads/news/').$news_detail['image'];?>" width="100%;" alt="<?php echo $news_detail['name'];?>" />
							<?php else: ?>
								<img src="<?php echo Router::url('/images/news-img.jpg');?>" width="100%;" alt="<?php echo $news_detail['name'];?>" />
							<?php endif; ?>
							</div>            	
							<div class="news-detail-sec">
								<div class="author">
									<div class="avatar">
									<?php
									if(empty($news_detail['user'])):
									?>
										<img src="<?php echo Router::url('/images/user_small.png');?>" alt="" />
									<?php
									else:
										if($news_detail['user']['profile_pic'] != ''):
									?>
										<img src="<?php echo Router::url('/uploads/user_profile_pic/thumb/').$news_detail['user']['profile_pic'];?>" alt="<?php echo $news_detail['user']['name'];?>" />
									<?php
										else:
									?>
										<img src="<?php echo Router::url('/images/user_small.png');?>" alt="<?php echo $news_detail['user']['name'];?>" />
									<?php
										endif;
									endif;
									?>
									</div>
									<span><strong>By:</strong> 
									<?php
									if(empty($news_detail['user'])){
										echo 'Admin';
									}else{
										echo $news_detail['user']['name'];
									}
									?>									
									</span>
								</div>
								<div class="news-details-content ">
									<h4><?php echo $news_detail['name'];?></h4>
									<div class="row post-meta">	
										<div class="meta-info col-md-6">
											<ul>
												<li><i class="fa fa-calendar-o"></i> On <?php echo date('jS M Y',strtotime($news_detail['created']));?></li>
												<li><i class="fa fa-eye"></i><?php echo $news_detail['view'];?></li>
												<li><i class="fa fa-comments-o"></i><?php if(!empty($news_detail['news_comment']))echo count($news_detail['news_comment']);else echo 0;?></li>												
											</ul>
										</div>
										<div class="post-share col-md-6 text-right">
											<!--<span>Share On :</span>
											<img src="<?php echo Router::url('/');?>images/share.png" alt="">
											<div class="sharethis-inline-share-buttons"></div>-->
										</div>
									</div>
									<p><?php echo $news_detail['description'];?></p>
									<div class="post-comment">
										<div class="comment-list" id="comment_listing">
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
										</div>									
									
									<?php if(!empty($all_comments)){ ?>
										<div class="loader">
											<?php echo $this->Paginator->next('Load more'); ?>
										</div>	
									<?php } ?>
										
										<div class="comment-form">
											<h5>Post Your Comments</h5>
											<div class="comment-form-container">
												<div id="post_msg"></div>
											<?php
											echo $this->Form->create(false,['url' => 'javascript:void(0);', 'id' => 'news_comment_form', 'novalidate' => 'novalidate']);
												echo $this->Form->input('news_id',['type'=>'hidden', 'value'=>base64_encode($news_detail['id']), 'label'=>false, 'div'=>false]);
												if(empty($Auth)){
											?>
													<div class="row">
														<div class="col-md-3">
															<label for="">Name</label>
														</div>
														<div class="col-md-9">
														 <div class="form-group">
															<?php echo $this->Form->input('name',['type'=>'text', 'label'=>false, 'placeholder'=>'Name', 'class'=>'form-control', 'required'=>true]);?>
														 </div>
														</div>
													</div>
													
													<div class="row">
														<div class="col-md-3">
															<label for="">Email</label>
														</div>
														<div class="col-md-9">
														 <div class="form-group">
															<?php echo $this->Form->input('email',['type'=>'email', 'label'=>false, 'placeholder'=>'Email', 'class'=>'form-control', 'required'=>true]);?>
														 </div>
														</div>
													</div>
											<?php
												}
											?>
													
													<div class="row">
														<div class="col-md-3">
															<label for="">Comment</label>
														</div>
														<div class="col-md-9">
															<div class="form-group">
																<?php echo $this->Form->input('comment',['type'=>'textarea', 'label'=>false, 'placeholder'=>'Comment', 'class'=>'form-control', 'required'=>true]);?>
															</div>
															<div class="btn-set"><input type="submit" value="Submit" class="btn-normal"></div>
															<div id="postcomment_loader" style="text-align:center;"></div>
														</div>
													</div>
												<?php echo $this->Form->end();?>
											</div>
										</div>
									</div>
								</div>
							</div>
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
<script>
//post news comment
$('#news_comment_form').validate({
	submitHandler:function(){
		$('#postcomment_loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var data = $('#news_comment_form').serialize();
		var promise = $.post('<?php echo Router::url("/news/news-comment-submission/",true); ?>',data);
		promise.done(function(response){
			$('#postcomment_loader').html('');
			var data = JSON.parse(response);
			if(data.comment == 'success'){
				var post_msg = "<div class='message success' onclick='this.classList.add('hidden')'>Your comment has been successfully submitted.</div>";
				$('#post_msg').html(post_msg);
				$('#news_comment_form')[0].reset();
				setTimeout(function(){
					$('#post_msg').html('');
				},5000);
			}else if(data.comment == 'success_approval'){
				var post_msg = "<div class='message success' onclick='this.classList.add('hidden')'>Your comment has been successfully submitted. It will show after Admin approval.</div>";
				$('#post_msg').html(post_msg);
				$('#news_comment_form')[0].reset();
				setTimeout(function(){
					$('#post_msg').html('');
				},5000);
			}else{
				var post_msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
				$('#post_msg').html(post_msg);
				setTimeout(function(){
					$('#post_msg').html('');
				},5000);
			}
		});
		promise.fail(function(){
			$('#postcomment_loader').html('');
			var post_msg = "<div class='message error' onclick='this.classList.add('hidden')'>There was an unexpected error. Try again later or contact the Admin.</div>";
			$('#post_msg').html(post_msg);
			setTimeout(function(){
				$('#post_msg').html('');
			},5000);
		});
	}
});
jQuery(function(){
	$(document).on('click', 'a[rel="next"]', function() {
		$('.next').remove();
		$('.loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var target = $(this).attr('href').replace("details","search_comments");
		var data = $('#search_form1').serialize();
		if(!target)
			return false;
		$.post(target, data, function(data) {
			$('.loader').remove();
			var e1 = jQuery(data);
			$('.next').remove();
			$('#comment_listing').append( data );
		}, 'html');
		return false;
	});
});
</script>