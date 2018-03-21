<?php use Cake\Routing\Router; ?>
<style>
.item-list-headings{display: flex; flex-flow: column nowrap; line-height: 1.4rem; list-style: outside none none; margin: 0; padding: 0;}
.item-list-headings .item-col {display: flex; flex: 3 3 0; margin-left: auto; margin-right: auto; min-width: 0; padding: 10px 10px 10px 0;}
.item-list-headings .item-row {align-items: stretch; display: flex; flex-flow: row wrap; justify-content: space-between; min-width: 100%;}
.item-list-headings .item-list-header .item-col.item-col-header span {color: #999; font-size: 0.8rem; font-weight: 700 !important;}
.item-list{height:210px !important; overflow-y: auto;}
.align-center{text-align:center; display:inline-block !important;}
.item-row{padding:0 !important;}
</style>
<article class="content items-list-page">   
   <div class="title-search-block">
      <div class="title-block">
         <div class="row">
            <div class="col-md-9">
               <h3 class="title">
                  User Submitted Details                  
               </h3>
            </div>
         </div>
      </div>      
   </div>
   
	<!-- Question Details Start-->
	<div class="card items">
		<h4><strong>Questions:</strong></h4>
		<ul class="item-list-headings striped">
			<li class="item item-list-header hidden-sm-down">
				<div class="item-row">
				   <div class="item-col item-col-header item-col-name">
					  <div> <span><a>Question</a></span> </div>                  
				   </div>
					<div class="item-col item-col-header item-col-parent align-center">
						<div> <span><a>Category</a></span></div>
					</div>
					<div class="item-col item-col-header item-col-featured align-center">
						<div> <span><a>Featured</a></span> </div>
					</div>
					<div class="item-col item-col-header item-col-created align-center">
						<div> <span><a>Added On</a></span> </div>
					</div>
				   <div class="item-col item-col-header item-col-status align-center">
				   <div> <span><a>Status</a></span> </div>
				   </div>
				</div>
			 </li>
		</ul>
		<ul class="item-list striped">
         <?php
         if(empty($submitted_questions)): ?>
            <li class="item">
				<div class="item-row">
				   <div>No results found</div>
				</div>
			 </li>
         <?php
         endif;
          foreach($submitted_questions as $question): ?>
			<li class="item table-data" id="row_id_<?php echo $question->id;?>">
			<div class="item-row">
			   <div class="item-col item-col-name">
				  <div class="item-heading">Question</div>
				  <div><?php echo substr($question->name, 0, 100); if(strlen($question->name)>100){ echo '...'; } ?></div>
			   </div>
			   <div class="item-col item-col-parent align-center">
				  <div class="item-heading">Category</div>
				  <div><?php if($question->question_category->name != '') echo $question->question_category->name; else echo 'N/A'; ?> </div>
			   </div>
			   <div class="item-col item-col-featured align-center">
				  <div class="item-heading">Featured</div>
				  <div><?php if($question->is_featured == 'Y'): echo "Yes"; else: echo "No"; endif; ?> </div>
			   </div>
			   <div class="item-col item-col-created align-center">
				  <div class="item-heading">Created</div>
				  <div><?php echo date('jS F Y', strtotime($question->created));?> </div>
			   </div>
			   <div class="item-col item-col-status align-center">
				  <div class="item-heading">Status</div>
				  <div data-id="status<?php echo $question->id; ?>">  <?php if($question->status == 'I'): echo "<b>Inactive</b>"; else: echo "Active"; endif; ?> </div>
			   </div>
			</div>
		 </li>
		<?php endforeach; ?>
      </ul>
   </div>
	<!--Question Details End-->
	
	<div>&nbsp;</div><div>&nbsp;</div>
	
	<!--Question Comments Start-->
	<div class="card items">
		<h4><strong>Question Comments:</strong></h4>
		<ul class="item-list-headings striped">
			<li class="item item-list-header hidden-sm-down">
				<div class="item-row">
				   <div class="item-col item-col-header item-col-name">               
					  <div><span><a>Comment</a></span></div>                  
				   </div>
					<div class="item-col item-col-header item-col-parent align-center">
						<div><span><a>Question</a></span></div>
					</div>
					<div class="item-col item-col-header item-col-featured align-center">
						<div><span><a>Added On</a></span></div>					
					</div>
				   <div class="item-col item-col-header item-col-status align-center">
						<div><span><a>Status</a></span></div>                  
				   </div>
				</div>
			 </li>
		</ul>
		<ul class="item-list striped">         
         <?php
         if(empty($comment_details)): ?>
            <li class="item">
				<div class="item-row">
				   <div>No results found</div>
				</div>
			 </li>
         <?php
         endif;
          foreach($comment_details as $comment): ?>
			<li class="item table-data" id="row_id_<?php echo $comment->id;?>">
			<div class="item-row">
			   <div class="item-col item-col-name">
				  <div class="item-heading">Comment</div>
				  <div><?php echo substr($comment->comment, 0, 100); if(strlen($comment->comment)>100){ echo '...'; } ?></div>
			   </div>
			   <div class="item-col item-col-parent align-center">
				  <div class="item-heading">Question</div>
				  <div><?php if($comment->question->name != '') echo substr($comment->question->name, 0, 100); else echo 'N/A'; if(strlen($comment->question->name)>100){ echo '...'; } ?> </div>
			   </div>
			   <div class="item-col item-col-featured align-center">
				  <div class="item-heading">Added On</div>
				  <div><?php if($comment->created != ''): echo date('jS F Y', strtotime($comment->created)); else: echo "N/A"; endif; ?> </div>
			   </div>
			   <div class="item-col item-col-status align-center">
				  <div class="item-heading">Status</div>
				  <div data-id="status<?php echo $comment->id; ?>">  <?php if($comment->status == 0): echo "<b>Inctive</b>"; else: echo "Active"; endif; ?> </div>
			   </div>
			</div>
		 </li>
            <?php endforeach; ?>
      </ul>
   </div>
	<!--Question Comments End-->
	
	<div>&nbsp;</div><div>&nbsp;</div>
	
	<!--Question Answers Start-->
	<div class="card items">
		<h4><strong>Question Answers:</strong></h4>
		<ul class="item-list-headings striped">
			<li class="item item-list-header hidden-sm-down">
				<div class="item-row">
				   <div class="item-col item-col-header item-col-name">               
					  <div> <span><a>Answer</a></span> </div>                  
				   </div>
					<div class="item-col item-col-header item-col-parent align-center">
						<div><span><a>Question</a></span></div>
					</div>
					<div class="item-col item-col-header item-col-created align-center">
						<div><span><a>Added On</a></span></div>		
					</div>
					<div class="item-col item-col-header item-col-status align-center">
						<div><span><a>Status</a></span></div>					  
				   </div>
				</div>
			 </li>
		</ul>
		<ul class="item-list striped">         
         <?php
         if(empty($answer_details)): ?>
            <li class="item">
                    <div class="item-row">
                       <div>No results found</div>
                    </div>
                 </li>
         <?php
         endif;
          foreach($answer_details as $answer): ?>
			<li class="item table-data" id="row_id_<?php echo $answer->id;?>">
			<div class="item-row">
			   <div class="item-col item-col-name">
				  <div class="item-heading">Answer</div>
				  <div><?php echo substr($answer->learning_path_recommendation, 0, 100); if(strlen($answer->learning_path_recommendation)>100){ echo '...'; } ?></div>
			   </div>
			   <div class="item-col item-col-parent align-center">
				  <div class="item-heading">Question</div>
				  <div><?php if($answer->question->name != '') echo substr($answer->question->name, 0, 100); else echo 'N/A'; if(strlen($answer->question->name)>100){ echo '...'; } ?> </div>
			   </div>
			   <div class="item-col item-col-created align-center">
				  <div class="item-heading">Added On</div>
				  <div><?php if($answer->created != ''): echo date('jS F Y', strtotime($answer->created)); else: echo "N/A"; endif; ?> </div>
			   </div>
			   <div class="item-col item-col-status align-center">
				  <div class="item-heading">Status</div>
				  <div data-id="status<?php echo $answer->id; ?>">  <?php if($answer->status == 'I'): echo "<b>Inctive</b>"; else: echo "Active"; endif; ?> </div>
			   </div>			   
			</div>
		 </li>
            <?php endforeach; ?>
      </ul>
	</div>
	<!--Question Answers End-->
	
	<div>&nbsp;</div><div>&nbsp;</div>
	
	<!--Question Answer Comments Start-->
	<div class="card items">
		<h4><strong>Question Answer Comments:</strong></h4>
		<ul class="item-list-headings striped">
			<li class="item item-list-header hidden-sm-down">
				<div class="item-row">
				   <div class="item-col item-col-header item-col-name">
					  <div> <span><a>Comment</a></span></div>
				   </div>
					<div class="item-col item-col-header item-col-parent align-center">
						<div><span><a>Question</a></span></div>
					</div>
					<div class="item-col item-col-header item-col-created align-center">
						<div><span><a>Added On</a></span></div>					
					</div>
				   <div class="item-col item-col-header item-col-status align-center">
						<div><span><a>Status</a></span></div>
				   </div>
				</div>
			 </li>
		</ul>
		<ul class="item-list striped">			 
         <?php
         if(empty($answer_comment_details)): ?>
            <li class="item">
				<div class="item-row">
				   <div>No results found</div>
				</div>
			 </li>
         <?php
         endif;
          foreach($answer_comment_details as $comment): ?>
			<li class="item table-data" id="row_id_<?php echo $comment->id;?>">
			<div class="item-row">
			   <div class="item-col item-col-name">
				  <div class="item-heading">Comment</div>
				  <div><?php echo substr($comment->comment, 0, 200); if(strlen($comment->comment)>200){ echo '...'; } ?></div>
			   </div>
			   <div class="item-col item-col-parent align-center">
				  <div class="item-heading">Question</div>
				  <div><?php if($comment->question->name != '') echo $comment->question->name; else echo 'N/A';?></div>
			   </div>
			   <div class="item-col item-col-featured align-center">
				  <div class="item-heading">Added On</div>
				  <div><?php if($comment->created != ''): echo date('jS F Y', strtotime($comment->created)); else: echo "N/A"; endif; ?> </div>
			   </div>
			   <div class="item-col item-col-status align-center">
				  <div class="item-heading">Status</div>
				  <div data-id="status<?php echo $comment->id; ?>">  <?php if($comment->status == 0): echo "Inctive"; else: echo "Active"; endif; ?> </div>
			   </div>			   
			</div>
		 </li>
            <?php endforeach; ?>
      </ul>
	</div>
	<!--Question Answer Comments End-->
	
</article>