<?php
use Cake\Routing\Router;
$session  = $this->request->session();
$userdetail = $session->read('Auth.Users');
$answer_upvote=0;
?>
<div class="genpage-user-system">
    <div class="container">
		<div class="genpage-wrapper">
			<div class="row">
				<div class="col-md-9 col-sm-8">
					<div class="title">
						<h1>Question Details</h1>
					</div>
					<div class="page-body post-question-area">
						<div class="form-wrapper question-post-from">
							<div class="row">
								<div class="col-md-7 col-sm-6">
									<div class="Q-left">
										<h2><small class="hastag">#<?php echo $detail->id;?> </small><?php echo $detail->name;?></h2>
										<?php echo $detail->short_description;?>
										<div class="Q-tags"><br />
									<?php
									if(!empty($detail->question_tags)){
										foreach($detail->question_tags as $tags){
											echo '<a>'.$tags->tag->title.'</a>';
										}
									}
									?>
										</div>
									</div>
								</div>
								<div class="col-md-5 col-sm-6 Q_info">
									<div class="Q_info_view">
										<div><?php echo $detail->view;?></div>
										<span>Views</span>
									</div>
									<div class="Q_info_ans">
										<div><?php echo count($detail->question_answer);?></div>
										<span>answers </span>
									</div>
									<div class="Q_info_vote">
										<div id="total_votes"></div>
										<span>Votes</span>
									</div>
								</div>
							</div>
							<div class="row question-info">
								<div class="col-md-6 col-sm-4"> <span class="ased_by">Category : <a href="<?php echo Router::url(array('controller'=>'','action'=>'category/',$detail->question_category->slug, false));?>"><?php echo $detail->question_category->name;?></a></span> <span class="ased_by">Posted On : <?php echo date('jS F Y',strtotime($detail->created));?></span> </div>
								<div class=" col-md-6 col-sm-8">
								<?php if(empty($Auth)){ ?>
									<a href="javascript:void(0);" class="btn-small post-ans-btn" data-target="#comment_vote">Post Your Answer</a>
									<a href="javascript:void(0);" class="btn-small-alt" data-toggle="modal" data-target="#comment_vote">Share a Comment</a>
								<?php }else{ ?>
									<a href="javascript:void(0);" class="btn-small post-ans-btn" data-target="#comment_vote">Post Your Answer</a>
									<a href="javascript:void(0);" class="btn-small-alt" data-toggle="modal" data-target="#comment-from-popup">Share a Comment</a>
								<?php } ?>
								</div>
							</div>               
							<div class="question-details-content">
							<?php
							if($detail->learning_goal != ''){
							?>
								<h5>Learning Goal</h5>
							<?php
								echo $detail->learning_goal.'<br />';
							}
							if($detail->education_history != ''){
							?>
								<h5>Starting level </h5>
							<?php
								echo $detail->education_history.'<br /><br />';
							}
							if($detail->budget_constraints != ''){
							?>
								<h5>Budget & other constraints</h5>
							<?php
								echo $detail->budget_constraints.'<br />';
							}
							if($detail->preferred_learning_mode != ''){
							?>
								<h5>Optional input on preferred learning mode </h5>
							<?php
								echo $detail->preferred_learning_mode.'<br />';
							}
							?>
							</div>                
						<?php
						if(!empty($detail->question_comment)){
							$m=1;
						?>
							<!-- Question comment Start here-->
							<div class="comment-sec">
								<h5>Comments</h5>
								<div class="post-comment question-comment">
									<div class="comment-list">
										<ul>
						<?php
										foreach($detail->question_comment as $question_comment){
											if($m<=2){
						?>
											<small class="hastag">#<?php echo $question_comment->id;?> </small>
											<li>												
												<div class="comment-avatar">
												<?php
												if(empty($question_comment->user)):
												?>
													<figure><img src="<?php echo Router::url('/images/user_small.png');?>" alt="" class="img_user" /></figure>
												<?php
												else:
													if($question_comment->user->profile_pic != ''):
												?>
													<figure><img src="<?php echo Router::url('/uploads/user_profile_pic/thumb/').$question_comment->user->profile_pic;?>" alt="<?php echo $question_comment->user->name;?>" class="img_user" /></figure>
												<?php
													else:
												?>
													<figure><img src="<?php echo Router::url('/images/user_small.png');?>" alt="<?php echo $question_comment->user->name;?>" class="img_user" /></figure>
												<?php
													endif;
												endif;
												?>
												</div>
												<div class="comment">
													<p><?php echo $question_comment->comment;?></p>
													<div>
														<div class="comment-meta"> By <?php echo $question_comment->user->name;?></div>
														<div class="comment-meta"> On <?php echo date('jS F Y', strtotime($question_comment->created));?></div>
													</div>
												</div>
											</li>
						<?php
											}
											$m++;
										}
						?>
										</ul>
						<?php
									if( count($detail->question_comment) > 2 ){
						?>
									<a href="javascript:void(0);" onclick="all_question_comments('<?php echo base64_encode($detail['id']);?>')">View all comments</a>&nbsp;<span id="question_comment_loader"></span>
						<?php
									}
						?>
									</div>
								</div>
							</div>
							<!-- Question comment End here-->
						<?php
						}
						?>
						<?php if(count($detail->question_answer) > 0){ ?>
							<h5><?php echo count($detail->question_answer);?> Answers</h5>
							<!-- Answer listing start -->
						<?php
							//pr($detail->question_answer); die;
							foreach($detail->question_answer as $answer){
						?>
							<div class="answer-items">
								<small class="hastag">#<?php echo $answer->id;?> </small>
								<div class="answer-top" style="padding-bottom:0;">							   
									<div class="ans-post">
										<div class="row">
											<div class="col-md-12 col-md-12 ans-by">
												<div class="_ans_posted_by">
													<div class="avatar">													
													<?php
													if(empty($answer->user)):
													?>
														<figure><img src="<?php echo Router::url('/images/user_small.png');?>" alt="" class="img_user" /></figure>
													<?php
													else:
														if($answer->user->profile_pic != ''):
													?>
														<figure><img src="<?php echo Router::url('/uploads/user_profile_pic/thumb/').$answer->user->profile_pic;?>" alt="<?php echo $answer->user->name;?>" class="img_user" /></figure>
													<?php
														else:
													?>
														<figure><img src="<?php echo Router::url('/images/user_small.png');?>" alt="<?php echo $answer->user->name;?>" class="img_user" /></figure>
													<?php
														endif;
													endif;
													?>
													</div>
													<div class="avatar-info"> By <?php echo $answer->user->name;?><br>
													<?php echo date('jS F Y', strtotime($answer->created));?></div>
												</div>
												<div class="Q_info text-left pull-left">
													<div class="Q_info_vote">
														<div id="vote_<?php echo $detail->id;?>_<?php echo $answer->id;?>" class="vote_<?php echo $detail->id;?>"><?php echo count($answer->answer_upvote);?></div>
														<span>Votes</span>
													</div>
												</div>
												<?php $answer_upvote = $answer_upvote + count($answer->answer_upvote); ?>
											<?php
											if($userdetail != ''){
												if($answer->user->id != $userdetail['id']){
											?>
													<div class="btn-set">
														<a href="javascript:void(0);" class="btn-small vote-ans-btn" id="upvote_<?php echo $detail->id;?>_<?php echo $answer->id;?>" onclick="upvote_answer(<?php echo $detail->id;?>,<?php echo $answer->id;?>,<?php echo $answer->user->id;?>);">Upvote</a> &nbsp;
														<a href="javascript:void(0);" class="btn-small-alt" data-toggle="modal" onclick="post_answer_comment('<?php echo base64_encode($detail->id);?>','<?php echo base64_encode($answer->id);?>','<?php echo base64_encode($answer->user->id);?>','1');">Share a comment</a><br />
														<div id="upvote_loader_<?php echo $detail->id;?>_<?php echo $answer->id;?>"></div>
														<div id="upvote_msg_<?php echo $detail->id;?>_<?php echo $answer->id;?>"></div>
													</div>
											<?php
												}
											}else{
											?>
													<div class="btn-set">
														<a href="javascript:void(0);" class="btn-small vote-ans-btn" data-target="#comment_vote" data-toggle="modal">Upvote</a> &nbsp;
														<a href="javascript:void(0);" class="btn-small-alt" data-toggle="modal" data-target="#comment_vote">Share a comment</a>
													</div>
											<?php
											}
											?>
											</div>
										</div>
									</div>
								</div>
								<strong>Learning Path recommendation:</strong> <?php echo $answer['learning_path_recommendation'];?>	<!-- this is user post answer (page end form)-->
								<strong>What was your learning experience:</strong> <?php echo $answer['learning_experience'];?>	<!-- this is user post answer (page end form)-->
								<strong>What was your learning utility:</strong> <?php echo $answer['learning_utility'];?>	<!-- this is user post answer (page end form)-->
						<?php
						if(!empty($answer->answer_comment)){	//answer comment is here
							$n=1;
						?>
								<div class="comment-sec">
									<h5>Answer Comments</h5>
									<div class="post-comment question-comment">
										<div class="comment-list">
											<ul>
						<?php
											foreach($answer->answer_comment as $ans_com){
												if($n<=2){
						?>
												<small class="hastag">#<?php echo $ans_com->id;?> </small>
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
												$n++;
											}
						?>
											</ul>
						<?php
											if( count($answer->answer_comment) > 2 ){
						?>
												<a href="javascript:void(0);" onclick="all_answer_comments('<?php echo $answer['id'];?>')">View all comments</a>&nbsp;<span id="answer_comment_loader_<?php echo $answer['id'];?>"></span>
						<?php
											}
						?>
										</div>						
									</div>						
								</div>
						<?php
						}
						?>
							</div>
						<?php
							}
						?>
							<!-- Answer listing  end -->	
						<?php
						}
						?>
						</div><hr style="border: 1px solid #d7d4d4;" />
						<div class="post-answer-sec">
							<!--Please <a href="javascript:void(0);" class="btn-small vote-ans-btn" id="login_signup_popup">Login</a> to post your answer.-->
							<?php
							echo $this->Form->create(false, array('url'=>'javascript:void(0)', 'novalidate' => 'novalidate', 'id'=>'post_answer_form'));
								echo $this->Form->input('question_id',['type'=>'hidden', 'value'=>base64_encode($detail['id'])]);
							?>
								<div class="form-group">                			
									<h5>Type your answer here</h5>                			
									<label>Learning Path recommendation</label>                			
									<div id="lpr"><?php echo $this->Form->input('learning_path_recommendation',['type'=>'textarea', 'id'=>'recomandation', 'label'=>false, 'class'=>'texarea', 'required'=>true]); ?></div>
								</div>
								<div class="form-group">
									<label for="">What was your learning experience</label>
									<div id="le"><?php echo $this->Form->input('learning_experience',['type'=>'textarea', 'id'=>'learning-experience', 'label'=>false, 'class'=>'texarea', 'required'=>true]); ?></div>
								</div>
								<div class="form-group">
									<label for="">What was your learning utility</label>
									<div id="lu"><?php echo $this->Form->input('learning_utility',['type'=>'textarea', 'id'=>'utility', 'label'=>false, 'class'=>'texarea', 'required'=>true]); ?></div>
								</div>
								
								<div id="answer_msg"><?php echo $this->Flash->render();?></div>
								
								<div class="button-set text-right" id="post_your_answer">
								<?php //if(!empty($Auth)){ ?>
									<input type="submit" class="btn-normal" id="login_signup_popup" value="Post Your Answer">
									<div id="postanswer_loader"></div>
								<?php /*}else{ ?>
									<input type="button" class="btn-normal" value="Post Your Answer" id="login_signup_popup">
								<?php }*/ ?>
								</div>               	        
							<?php echo $this->Form->end();?>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-4 question-right ">            
					<?php echo $this->element('right_panel_question_details'); ?>
				</div>
			</div>
		</div>
    </div>
</div>

<?php echo $this->element('post_answer');?>

<?php echo $this->element('comment_vote');?>

<?php echo $this->element('answer_comment');?>


<!-- Answer comments will show start here -->
<div class="modal fade" id="answer_comment_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">All Comments</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="all_comments"></div>
			</div>
		</div>
	</div>
</div>
<!-- Answer comments will end here -->

<script>
$(document).ready(function(){
	$('#total_votes').html('<?php echo $answer_upvote;?>');
});

//getting answer comment section start here
function all_answer_comments(answer_id){
	$('#answer_comment_loader_'+answer_id).html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
	$.ajax({
		url:"<?php echo Router::url("/questions/ajax-all-answer-comments/",true); ?>",
		type: 'POST',
		data: {answer_id : answer_id},
		success: function(data){
			$('#answer_comment_loader_'+answer_id).html('');
			$('#all_comments').html('');
			$('#answer_comment_popup').modal('show');
			$('#all_comments').html(data);
		}
	});
}
//getting answer comment section end here

//getting question comment section start here
function all_question_comments(question_id){
	$('#question_comment_loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
	$.ajax({
		url:"<?php echo Router::url("/questions/ajax-all-question-comments/",true); ?>",
		type: 'POST',
		data: {question_id : question_id},
		success: function(data){
			$('#question_comment_loader').html('');
			$('#all_comments').html('');
			$('#answer_comment_popup').modal('show');
			$('#all_comments').html(data);
		}
	});
}
//getting question comment section end here
</script>
<?php echo $this->element('social_login');?>
<style>
.side-bar-block-box ul li{min-height:40px !important;}
</style>