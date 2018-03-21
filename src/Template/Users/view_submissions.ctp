<?php
use Cake\Routing\Router;
$session  = $this->request->session();
?>
<div class="genpage-user-system">
	<div class="container">
		<div class="title">
			<h1>User Submissions</h1> 
		</div>
		<div class="genpage-wrapper">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="user-profile-details">              
						<div class="edit-details-wrapper">
							<div id="edit_profile_msg"><?php echo $this->Flash->render();?></div>
							<div class="about-user-row table_wrap">
								<h3>Questions:</h3>
								<div class="table-responsive table-striped">
									<table width="100%" border="1">
										<tr>
											<th>Question</th>
											<th>Category</th>
											<th>Created On</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
										<?php
										if(empty($submitted_questions)):
											echo '<tr><td colspan="5" align="center"><p>No results found</p></td></tr>';
										else:
										foreach($submitted_questions as $question):
										?>
										<tr>
											<td><?php echo substr($question->name, 0, 100); if(strlen($question->name)>100){ echo '...'; } ?></td>
											<td><?php if($question->question_category->name != '') echo $question->question_category->name; else echo 'N/A'; ?></td>
											<td><?php echo date('jS F Y', strtotime($question->created));?></td>
											<td><?php if($question->status == 'I'): echo "<b>Inactive</b>"; else: echo "Active"; endif; ?></td>
											<td><a class="edit" href="<?php echo Router::url(array('controller'=>'/','action'=>'edit-submitted-question',base64_encode($question->id))); ?>" title="Edit"><i class="fa fa-pencil"></i></a></td>
										</tr>
										<?php
											endforeach;
											endif;
										?>
									</table>
								</div>
								<!-- Question section end -->
								
								<!-- Question comments section start -->
								<h3>Question Comments:</h3>
								<div class="table-responsive table-striped">
									<table width="100%" border="1">
										<tr>
											<th>Comment</th>
											<th>Question</th>
											<th>Created On</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
										<?php
										if(empty($comment_details)):
											echo '<tr><td colspan="5" align="center"><p>No results found</p></td></tr>';
										else:
										foreach($comment_details as $comment):
										?>
										<tr>
											<td><?php echo substr($comment->comment, 0, 100); if(strlen($comment->comment)>100){ echo '...'; } ?></td>
											<td><?php if($comment->question->name != '') echo substr($comment->question->name, 0, 100); else echo 'N/A'; if(strlen($comment->question->name)>100){ echo '...'; } ?></td>
											<td><?php if($comment->created != ''): echo date('jS F Y', strtotime($comment->created)); else: echo "N/A"; endif; ?></td>
											<td><?php if($comment->status == 0): echo "<b>Inctive</b>"; else: echo "Active"; endif; ?></td>
											<td><a class="edit" href="<?php echo Router::url(array('controller'=>'/','action'=>'edit-submitted-question-comment',base64_encode($comment->id))); ?>" title="Edit"><i class="fa fa-pencil"></i></a></td>
										</tr>
										<?php
											endforeach;
											endif;
										?>
									</table>
								</div>
								<!-- Question comments section end -->
								
								<!-- Question Answer section start -->
								<h3>Question Answers:</h3>
								<div class="table-responsive table-striped">
									<table width="100%" border="1">
										<tr>
											<th>Answer</th>
											<th>Question</th>
											<th>Created On</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
										<?php
										if(empty($answer_details)):
											echo '<tr><td colspan="5" align="center"><p>No results found</p></td></tr>';
										else:
										foreach($answer_details as $answer):
										?>
										<tr>
											<td><?php echo substr($answer->learning_path_recommendation, 0, 100); if(strlen($answer->learning_path_recommendation)>100){ echo '...'; } ?></td>
											<td><?php if($answer->question->name != '') echo substr($answer->question->name, 0, 100); else echo 'N/A'; if(strlen($answer->question->name)>100){ echo '...'; } ?></td>
											<td><?php if($answer->created != ''): echo date('jS F Y', strtotime($answer->created)); else: echo "N/A"; endif; ?></td>
											<td><?php if($answer->status == 'I'): echo "<b>Inctive</b>"; else: echo "Active"; endif; ?></td>
											<td><a class="edit" href="<?php echo Router::url(array('controller'=>'/','action'=>'edit-submitted-question-answer',base64_encode($answer->id))); ?>" title="Edit"><i class="fa fa-pencil"></i></a></td>
										</tr>
										<?php
											endforeach;
											endif;
										?>
									</table>
								</div>
								<!-- Question Answer section end -->
								
								<!-- Question Answer Comment section start -->
								<h3>Question Answer Comments:</h3>
								<div class="table-responsive table-striped">
									<table width="100%" border="1">
										<tr>
											<th>Comment</th>
											<th>Question</th>
											<th>Created On</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
										<?php
										if(empty($answer_comment_details)):
											echo '<tr><td colspan="5" align="center"><p>No results found</p></td></tr>';
										else:
										foreach($answer_comment_details as $answer):
										?>
										<tr>
											<td><?php echo substr($answer->comment, 0, 100); if(strlen($answer->comment)>100){ echo '...'; } ?></td>
											<td><?php if($answer->question->name != '') echo substr($answer->question->name, 0, 100); else echo 'N/A'; if(strlen($answer->question->name)>100){ echo '...'; } ?></td>
											<td><?php if($answer->created != ''): echo date('jS F Y', strtotime($answer->created)); else: echo "N/A"; endif; ?></td>
											<td><?php if($answer->status == 'I'): echo "<b>Inctive</b>"; else: echo "Active"; endif; ?></td>
											<td><a class="edit" href="<?php echo Router::url(array('controller'=>'/','action'=>'edit-submitted-question-answer-comment',base64_encode($answer->id))); ?>" title="Edit"><i class="fa fa-pencil"></i></a></td>
										</tr>
										<?php
											endforeach;
											endif;
										?>
									</table>
								</div>
								<!-- Question Answer Comment section end -->
								
								<!-- News Comment section start -->
								<h3>News Comments:</h3>
								<div class="table-responsive table-striped">
									<table width="100%" border="1">
										<tr>
											<th>Comment</th>
											<th>News Title</th>
											<th>Created On</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
										<?php
										if(empty($news_comment_details)):
											echo '<tr><td colspan="5" align="center"><p>No results found</p></td></tr>';
										else:
										foreach($news_comment_details as $answer):
										?>
										<tr>
											<td><?php echo substr($answer->comment, 0, 100); if(strlen($answer->comment)>100){ echo '...'; } ?></td>
											<td><?php if($answer->news->name != '') echo substr($answer->news->name, 0, 100); else echo 'N/A'; if(strlen($answer->news->name)>100){ echo '...'; } ?></td>
											<td><?php if($answer->created != ''): echo date('jS F Y', strtotime($answer->created)); else: echo "N/A"; endif; ?></td>
											<td><?php if($answer->status == 'I'): echo "<b>Inctive</b>"; else: echo "Active"; endif; ?></td>
											<td><a class="edit" href="<?php echo Router::url(array('controller'=>'/','action'=>'edit-submitted-news-comment',base64_encode($answer->id))); ?>" title="Edit"><i class="fa fa-pencil"></i></a></td>
										</tr>
										<?php
											endforeach;
											endif;
										?>
									</table>
								</div>
								<!-- News Comment section end -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	setTimeout(function(){		
		$('#edit_profile_msg').html('');
	},3000);
});
</script>