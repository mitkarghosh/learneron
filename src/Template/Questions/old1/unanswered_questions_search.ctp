<?php use Cake\Routing\Router; ?>
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
						<div class="questionname">
							<span class="ased_by">asked <?php echo $time_ago; ?> ago By 
								<?php if(empty($question->user)){echo 'Admin';}else{echo $question->user->name;}?>
							</span>
						</div>
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
						<div><?php echo count($question->answer_upvote);?></div>
						<span>Votes</span>
					</div>
				</div>
			</div>
		</div>
<?php
	}
}
?>
<?php if(!empty($unanswered_questions)){ ?>
	<div class="loader">
		<?php echo $this->Paginator->next('Load more'); ?>
	</div>	
<?php } ?>