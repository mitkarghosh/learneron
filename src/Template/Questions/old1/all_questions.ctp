<?php use Cake\Routing\Router; ?>
<div class="search-banner">
	<div class="question-search-banner">
		<form action="<?php echo Router::url(NULL,true); ?>" method="get" id="search_form1">
			<input value="<?php if($this->request->query('search') !== NULL): echo $this->request->query('search'); endif; ?>" type="text" name="search" id="search-term" placeholder="Search by question name, description and user name..." autocomplete="off" />
			<button><i class="fa fa-search"></i></button> 
		</form>
	</div>
</div>
<?php echo $this->element('advertisement'); ?>
<div class="body-section">
	<section class="top-question-section search-question">
		<div class="container">
			<div class="row">
				<div class="col-md-9 col-sm-8 question-left"><a id="perpage"></a>
				<?php if($this->request->query('search') != NULL && $this->request->query('search') !=''){ ?>
					<div class="title">
						<h1><?php echo $total_count;?> Result(s) Found</h1>
						<p class="">For “<?php echo $this->request->query('search');?>”</p>
					</div>
				<?php } ?>
					<div class="question-nav clearfix">
						<ul>
							<li class="active"><a href="javascript:void(0);">Latest</a></li>
							<li><a href="<?php echo Router::url(['controller'=>'Questions','action'=>'most-viewed-questions']);?>#mostviewed_question">Most Viewed</a></li>
							<li><a href="<?php echo Router::url(['controller'=>'Questions','action'=>'un-answered-questions']);?>#unanswered">Unanswered</a></li>
						</ul>
						<?php echo $this->element('question_per_page');?>
					</div>
					<div id="questions_lising">
				<?php
				if(!empty($latest_questions)){
					foreach($latest_questions as $question){
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
										<div class="questionname">
											<a href="<?php echo Router::url(array('controller'=>'Questions','action'=>'details/',$converted_id, false));?>">
												<h2><?php echo strip_tags($question->name);?></h2>
											</a>
											<p><?php echo strip_tags(substr($question->short_description,0,130));?></p>
										</div>
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
				}else{
					echo '<p class="no_results_found">No results found</p>';
				}
				?>
					</div>            
				<?php if(!empty($latest_questions)){ ?>
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
		var target = $(this).attr('href').replace("all-questions","latestquestions_search/");
		//var target = 'http://localhost/learneron/questions/all-questions'.replace("all-questions","latestquestions_search/");
		//var target = '<?php echo Router::url(array('controller'=>'Questions','action'=>'all-questions', false));?>'.replace("all-questions","latestquestions_search");		
		//alert(target); return false;
		var data = $('#search_form1').serialize();
		//alert(data); return false;
		if(!target)
			return false;
		$.post(target, data, function(data) {
			$('.loader').remove();
			$('.next').remove();
			$('#questions_lising').append( data );
			<?php if($this->request->query('search') != NULL):?>
				searchAndHighlight($('#search-term').val(), ".questionname", 'highlighted');
			<?php endif;?>
		}, 'html');
		return false;
	});
});
$('#no_of_questions').on('change', function(){
	var url = '';
	<?php if(@$this->request->query('search') && $this->request->query('search') !== NULL){ ?>
		if(this.value != ''){
			url = '<?php echo Router::url(NULL,true).'?search='.$this->request->query('search').'&limit=';?>'+this.value+'#perpage';
		}else{
			url = '<?php echo Router::url(NULL,true).'?search='.$this->request->query('search');?>#perpage';
		}
	<?php }else{ ?>
		if(this.value != ''){
			url = '<?php echo Router::url(NULL,true).'?limit=';?>'+this.value+'#perpage';
		}else{
			url = '<?php echo Router::url(NULL,true);?>';
		}
	<?php } ?>
	window.location.href = url;
});

<?php if($this->request->query('search') !== NULL):?>
$(document).ready(function() {
    if(!searchAndHighlight($('#search-term').val(), ".questionname", 'highlighted')){/*alert("No results found");*/}
});
<?php endif;?>
</script>