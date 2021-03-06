<?php use Cake\Routing\Router; ?>
<div class="intro clearfix">
    <div class="container">
      <?php echo $this->element('advertisement'); ?>
      <div class="user-status clearfix">
        <div class="questions">
          <h2>Questions</h2>
          <h3><?php echo $total_questions;?></h3>
        </div>
        <div class="users">
          <h2>Users</h2>
          <h3><?php echo $total_users;?></h3>
        </div>
      </div>
    </div>
</div>
<section class="banner-sec">
    <div class="banner-wrapper container">
<?php
if(!empty($all_banners)){
?>
		<ul class="banner-slider">
<?php
	foreach($all_banners as $banner){
?>
        <li style="background: url(<?php echo Router::url('/uploads/banner/thumb/').$banner->image;?>)">
          <div class="caption">
            <h3><?php echo $banner->title;?></h3>
            <p><?php echo substr($banner->sub_title,0,750);?></p>
            <a href="<?php echo $banner->link;?>" class="btn btn-normal">view more</a> </div>
        </li>
<?php
	}
?>
      </ul>
<?php
}
?>
	</div>
</section><a id="perpage"></a>
<div class="body-section">
    <section class="top-question-section">
		<div class="container">
			<div class="row">
				<div class="col-md-9 col-sm-8 question-left" id="unanswered">
					<div class="title">
						<h1>Top Questions</h1>
					</div>
					<div class="question-nav clearfix">
						<ul>
							<li><a href="<?php echo Router::url('/'); ?>">Latest</a></li>
							<li><a href="<?php echo $this->Url->build(['controller'=>'Sites','action'=>'most-viewed']);?>#mostviewed_question">Most Viewed</a></li>
							<li class="active"><a href="javascript:void(0);">Unanswered</a></li>
						</ul>
						<?php echo $this->element('question_per_page');?>
					</div>
					<div id="questions_lising">
				<?php
				if(!empty($unanswered_questions)){
					foreach($unanswered_questions as $question){
						$time_ago = '';
						$question_created = strtotime($question->created);
						$time_diff = (time() - $question_created);
						if($time_diff >= 31536000){
							$time_ago = intval($time_diff / 31536000).' year(s)';
						}else if($time_diff >= 2419200){
							$time_ago = intval($time_diff / 2419200).' month(s)';
						}else if($time_diff >= 86400){
							$time_ago = intval($time_diff / 86400).' day(s)';
						}else if($time_diff >= 3600){
							$time_ago = intval($time_diff / 3600).' hour(s)';
						}else if($time_diff >= 60){
							$time_ago = intval($time_diff / 60).' min(s)';
						}else{
							$time_ago = 'less than a min';
						}
				?>
						<div class="quetion-lists">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="Q-left">
										<?php $converted_id = base64_encode($question->id);?>
										<a href="<?php echo Router::url(array('controller'=>'Questions','action'=>'details/',$converted_id, false));?>">
											<h2><?php echo strip_tags($question->name);?></h2>
										</a>
										<p><?php echo strip_tags(substr($question->short_description,0,130));?></p>
				<?php
								if(!empty($question->question_tags)){
									echo '<div class="Q-tags">';
									foreach($question->question_tags as $tags){
				?>
										<a href="<?php echo Router::url(array('controller'=>'','action'=>'tag/',$tags->tag->slug, false));?>"><?php echo $tags->tag->title;?></a>
				<?php
									}
									echo '</div>';
								}
								echo '<p class="question_category"><a href="'.Router::url(array('controller'=>'','action'=>'category/',$question->question_category->slug, false)).'">'.$question->question_category->name.'</a></p>';
				?>
										<span class="ased_by">asked <?php echo $time_ago; ?> ago By 
											<?php if(empty($question->user)){echo 'Admin';}else{echo $question->user->name;}?>
										</span>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 Q_info">
									<div class="Q_info_view">
										<div><?php echo $question->view;?></div>
										<span>Views</span>
									</div>
									<div class="Q_info_ans">
										<div><?php echo count($question->question_answer);?></div>
										<span>answers </span>
									</div>
									<div class="Q_info_vote">
										<div>
										<?php //echo count($question->answer_upvote);
										$voting_count = 0;
										if( !empty($question->question_answer) ){
											foreach( $question->question_answer as $key_qa => $val_qa ){
												if( !empty($val_qa->answer_upvote) ){
													foreach( $val_qa->answer_upvote as $key_au => $val_au ){
														$voting_count++;
													}
												}
											}
										}
										echo $voting_count;
										?>
										</div>
										<span>Votes</span>
									</div>
								</div>
							</div>
						</div>
				<?php
					}
				}else{
					echo '<p class="no_results_found">No results found</p>';
				}
				?>
					</div>            
				<?php if(!empty($unanswered_questions)){ ?>
					<div class="loader">
						<?php echo $this->Paginator->next('Load more'); ?>
					</div>	
				<?php } ?>
				</div>
				<div class="col-md-3 col-sm-4 question-right ">
					<?php echo $this->element('right_panel_1'); ?>
				</div>
			</div>
		</div>
    </section>
</div>
<script>
$(function(){
	$(document).on('click', 'a[rel="next"]', function() {
		$('.next').remove();
		$('.loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
		var target = $(this).attr('href').replace("un-answered","unanswered_search");
		var data = $('#search_form1').serialize();
		if(!target)
			return false;
		$.post(target, data, function(data) {
			$('.loader').remove();
			$('.next').remove();
			$('#questions_lising').append( data );
		}, 'html');
		return false;
	});
});
$('#no_of_questions').on('change', function(){
	var url = '<?php echo Router::url(array('controller'=>'/','action'=>'un-answered'.'?limit='));?>'+this.value+'#perpage';
	window.location.href = url;
});
</script>