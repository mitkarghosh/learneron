<?php use Cake\Routing\Router; ?>
<article class="content dashboard-page">
    <div class="row">
		<div class="col-lg-12">
			<div id="flashmessage"><?php echo $this->Flash->render().'<br />';?></div>
			<h1 style="text-align:center;margin:0 0 50px 0;">Welcome to LearnerOn Admin Panel</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div id="page-wrapper">		
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-primary panel-blue">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-users fa-4x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $total_inactive_users;?> / <?php echo $total_users;?></div>
								<div>In-Active Users!</div>
							</div>
						</div>
					</div>
					<a href="<?php echo Router::url(array('controller'=>'Users','action'=>'listData'),true);?>">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-comments fa-4x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $total_inactive_news_comments;?> / <?php echo $total_news_comments;?></div>
								<div>Unapproved News Comments!</div>								
							</div>
						</div>
					</div>
					<a href="<?php echo Router::url(array('controller'=>'NewsComments','action'=>'listData'),true);?>">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-yellow">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-question-circle fa-4x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $total_inactive_questions;?> / <?php echo $total_questions;?></div>
								<div>In-Active Questions!</div>
								<div>&nbsp;</div>
							</div>
						</div>
					</div>
					<a href="<?php echo Router::url(array('controller'=>'questions','action'=>'listData'),true);?>">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-red">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-support fa-4x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $total_inactive_question_answer;?> / <?php echo $total_question_answer;?></div>
								<div>Unapproved Question Answers!</div>
							</div>
						</div>
					</div>
					<a href="<?php echo Router::url(array('controller'=>'QuestionAnswers','action'=>'listData'),true);?>">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="panel panel-sky">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-comment fa-4x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $total_inactive_questioncomments;?> / <?php echo $totalquestioncomments;?></div>
								<div>Unapproved Question Comments!</div>
							</div>
						</div>
					</div>
					<a href="<?php echo Router::url(array('controller'=>'QuestionComments','action'=>'listData'),true);?>">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="panel panel-deepgreen">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-comments fa-4x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge"><?php echo $total_inactive_answercomments;?> / <?php echo $totalanswercomments;?></div>
								<div>Unapproved Answer Comments!</div>
							</div>
						</div>
					</div>
					<a href="<?php echo Router::url(array('controller'=>'QuestionAnswers','action'=>'listData'),true);?>">
						<div class="panel-footer">
							<span class="pull-left">View Details</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-8">
				<!--Question Section start-->
			<?php if(!empty($all_question_details)){?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-bar-chart-o fa-fw"></i> Question Posted Monthly
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div id="morris-bar-chart"></div>
							</div>
							<!-- /.col-lg-12 (nested) -->
						</div>
						<!-- /.row -->
					</div>
					<!-- /.panel-body -->
				</div>
			<?php } ?>
				<!--Question Section end-->
				
				<!--Question Answer vs Question Comment Section start-->
			<?php if(!empty($all_question_answer_comment_details)){?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-bar-chart-o fa-fw"></i> Question Answer and Question Comment Posted Monthly
					</div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div id="morris-area-chart"></div>
					</div>
					<!-- /.panel-body -->
				</div>
			<?php } ?>
				<!--Question Answer vs Question Comment Section end-->
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-clock-o fa-fw"></i> Latest Contacted Users
					</div>
					<!-- /.panel-heading -->
			<?php if(!empty($latest_contacts)){ ?>
					<div class="panel-body">
						<ul class="timeline">
			<?php
						$i=1;
						foreach($latest_contacts as $contact){
			?>
							<li class='<?php if($i%2!=0)echo "";else echo "timeline-inverted";?>'>
								<div class="timeline-badge <?php if($i%2!=0)echo "info";else echo "warning";?>"><i class="fa fa-check"></i>
								</div>
								<div class="timeline-panel">
									<div class="timeline-heading">
										<h4 class="timeline-title"><?php echo $contact->name;?></h4>
										<p><a href="mailto:<?php echo $contact->email;?>"><small class="text-muted"><i class="fa fa-envelope fa-fw"></i> <?php echo $contact->email;?></small></a></p>
										<p><small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date('d M Y',strtotime($contact->created));?></small></p>
										<p><small class="text-muted"><i class="fa fa-tasks fa-fw"></i> <?php echo $contact->subject;?></small></p>
									</div>
									<div class="timeline-body">
										<?php echo $contact->message;?>
									</div>
								</div>
							</li>
			<?php
						$i++;
						}
			?>
						</ul>
					</div>
			<?php
			}else{echo '<p style="text-align:center">No results found.</p>';}
			?>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>
			<!-- /.col-lg-8 -->
			<div class="col-lg-4">
			
				<div class="panel panel-default">
					<div class="box box-success">
						<div class="box-header with-border">
							<h3 class="box-title">Online Users</h3>
							<div class="box-tools pull-right">
							<?php if(count($online_users)>1){?>
								<span class="label label-success"><?php echo count($online_users);?> Online User<?php if(count($online_users)>1)echo 's';?></span>
							<?php } ?>
							</div>
						</div><!-- /.box-header -->
					<?php
					if(!empty($online_users)){
					?>
						<div class="box-body no-padding" style="height:300px; overflow-y:scroll;">
							<ul class="users-list clearfix">
					<?php
							//$i=1;
							foreach($online_users as $user){
								//if($i<=8){
									if(empty($user->profile_pic)):
										$image = Router::url("/images/", true).'user.png';
									else:
										if($user->profile_pic != ''){
											$image = Router::url("/uploads/user_profile_pic/thumb/", true).$user->profile_pic;
										}else{
											$image = Router::url("/images/", true).'user.png';
										}								
									endif;
						?>
									<li>
										<img src="<?php echo $image;?>" alt="" style="height:60px;" />
										<a class="users-list-name" href="<?php echo Router::url(array('controller'=>'Users','action'=>'editUser/'.base64_encode($user->id)),true);?>"><?php echo $user['name'];?></a>								
									</li>
					<?php
								//}
							//$i++;
							}
					?>
							</ul><!-- /.users-list -->
						</div><!-- /.box-body -->
					<?php
					}else{echo '<p style="text-align:center">No results found.</p>';}
					?>
						<div class="box-footer text-center">
						  <a href="<?php echo Router::url(array('controller'=>'Users','action'=>'listData'),true);?>" class="btn btn-default btn-block">View All Users</a>
						</div><!-- /.box-footer -->
					</div><!--/.box -->
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-bar-chart-o fa-fw"></i> Question Posted by Users
					</div>
					<div class="panel-body">
						<div id="morris-donut-chart"></div>
						<a href="<?php echo Router::url(array('controller'=>'questions','action'=>'listData'),true);?>" class="btn btn-default btn-block">View Details</a>
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-bell fa-fw"></i> Recently Most Viewed Questions (7 Days)
					</div>
					<!-- /.panel-heading -->
			<?php
			if(!empty($recently_most_viewed_questions)){				
			?>
					<div class="panel-body">
						<div class="list-group">
			<?php
						foreach($recently_most_viewed_questions as $val_q){
			?>
							<a href="<?php echo $this->Url->build(['controller'=>'Questions','action'=>'editQuestion',base64_encode($val_q->id)]);?>" class="list-group-item">
								<i class="fa fa-question-circle"></i> <?php echo $val_q->name;?>
								</span>
							</a>
			<?php
						}
			?>
						</div>
						<!-- /.list-group -->
						<a href="<?php echo Router::url(array('controller'=>'questions','action'=>'listData'),true);?>" class="btn btn-default btn-block">View All Questions</a>
					</div>
			<?php
			}else{ echo '<p style="text-align:center">No results found.</p>';}
			?>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
				
				
			</div>
			<!-- /.col-lg-4 -->			
		</div>
		<!-- /.row -->
	</div>
</article>
<script>
$(function() {
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "By Admin",
            value: <?php echo $question_by_admin;?>
        }, {
            label: "By Users",
            value: <?php echo $question_by_user;?>
        }, {
            label: "By Facebook Users",
            value: <?php echo $question_by_facebookuser;?>
        }, {
            label: "By GPlus Users",
            value: <?php echo $question_by_gplususer;?>
        }, {
            label: "By Twitter Users",
            value: <?php echo $question_by_twitteruser;?>
        }, {
            label: "By LinkedIn Users",
            value: <?php echo $question_by_linkedinuser;?>
        }],
        resize: true
    });

<?php if(!empty($all_question_details)){ ?>
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [
<?php 	foreach($all_question_details as $key_question => $val_question){?>
		{
            y: '<?php echo $key_question;?>',
            a: <?php echo count($val_question['question']);?>
        },
<?php 	} //end of foreach?>
		],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Question'],
        hideHover: 'auto',
        resize: true
    });
<?php } ?>

<?php if(!empty($all_question_answer_comment_details)){ ?>
	Morris.Bar({
        element: 'morris-area-chart',
        data: [
<?php
		foreach($all_question_answer_comment_details as $key_ac => $val_ac){
			if(array_key_exists('answers',$val_ac)){$ans = count($val_ac['answers']);}else{$ans = 0;}
			if(array_key_exists('comments',$val_ac)){$com = count($val_ac['comments']);}else{$com = 0;}
?>
		{
            y: '<?php echo $key_ac;?>',
            a: <?php echo $ans;?>,
            b: <?php echo $com;?>
        },
<?php 	} //end of foreach ?>
		],
        xkey: 'y',
        ykeys: ['a','b'],
        labels: ['Answers','Comments'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });
<?php } ?>

	setTimeout(function(){
		$('#flashmessage').fadeTo(1000, 0.01, function(){$(this).slideUp(300, function() {$(this).remove();});});
	},3000);

});
</script>