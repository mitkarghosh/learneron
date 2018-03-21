<?php use Cake\Routing\Router; ?>
<div class="genpage-user-system">
    <div class="container">      
		<section class="top-question-section">
			<div class="container">
				<div class="row">
					<div class="col-md-9 col-sm-8">
						<div class="title">
							<h1>Tags</h1>
						</div>
						<div class="question-left tags-page-cont">
					<?php
					if(!empty($sorted_array)){
					?>
							<div class="search-by">
								<h3>Browse by alphabetically</h3>
								<ul>
					<?php
						foreach($alphabets_only as $key_ao => $val_ao){
					?>
									<li><a href="<?php echo Router::url(array('controller'=>'Tags')).'?search='.strtolower($key_ao);?>" <?php if(strtoupper($key_ao)==$element)echo 'style="color:#caa961"';?>><?php echo strtolower($key_ao);?></a></li>
					<?php
						}
					?>
									<li><a href="<?php echo Router::url(array('controller'=>'Tags'));?>">All</a></li>
								</ul>
							</div>							
					<?php
					if($element == ''){	//if not browse by alphabetically
						//$cur_date = '2017-08-29';
						$cur_date = date('Y-m-d');
						$current_date = strtotime(date($cur_date));
						$cur_week_prev_date = date('Y-m-d', strtotime('-6 days', strtotime($cur_date)));
						$current_week_prev_date = strtotime($cur_week_prev_date);
						
						$cur_month_first_date = date('Y-m-01');
						//$cur_month_last_date = date('Y-m-t');
						$current_month_first_date = strtotime($cur_month_first_date);
											
						$previous_key='';
						foreach($sorted_array as $key_sa => $val_sa){
							if(ord(strtolower($key_sa)) < 100){
								if($previous_key != $key_sa){
									$previous_key = $key_sa;
					?>
									<div class="quetion-lists">
										<div class="Q-left">
											<div class="row">
					<?php
								}
								$alphabetic_count = count($val_sa);
								$m=0;
								foreach($val_sa as $tags){
					?>
												<div class="col-md-3 col-sm-6">
													<div class="tagsWrap">
														<a href="<?php echo $this->Url->build(['controller'=>'Questions','action'=>'question-tag',$tags['slug']]);?>" class="tags"><span><?php echo $tags['title'];?></span><?php if(!empty($tags['question_tags']))echo ' x'.count($tags['question_tags']);?></a>
													</div>
													<span class="ased_by">
													<?php
													if(!empty($tags['question_tags'])){
														$today=0; $this_week=0; $this_month=0;
														foreach($tags['question_tags'] as $qt){
															$question_posted = strtotime(date('Y-m-d',strtotime($qt['question']['created'])));
															if($current_date == $question_posted){$today++;}
															if($question_posted >= $current_week_prev_date && $question_posted <= $current_date){$this_week++;}
															if($question_posted >= $current_month_first_date && $question_posted <= $current_date){$this_month++;}
														}
														if($today > 0){
															echo $today.' today, ';
														}
														if($this_week > 0){
															echo $this_week.' this week, ';
														}
														if($this_month > 0){
															echo $this_month.' this month';
														}
													}
													?>
													</span>
												</div>
					<?php
									$m++;
									if($m==$alphabetic_count){
					?>
											</div>
										</div>
									</div>
					<?php
									}
								}
							}else{
								//echo '<div class="rest_tags" style="display:none;">';
								if($previous_key != $key_sa){
									$previous_key = $key_sa;
					?>
									<div class="quetion-lists rest_tags" style="display:none;">
										<div class="Q-left">
											<div class="row">
					<?php
								}
								$alphabetic_count = count($val_sa);
								$m=0;
								foreach($val_sa as $tags){
					?>
												<div class="col-md-3 col-sm-6">
													<div class="tagsWrap">
														<a href="<?php echo Router::url(array('action'=>'tag/',$tags['slug'], false));?>" class="tags"><span><?php echo $tags['title'];?></span><?php if(!empty($tags['question_tags']))echo ' x'.count($tags['question_tags']);?></a>
													</div>
													<span class="ased_by">
													<?php
													if(!empty($tags['question_tags'])){
														$today=0; $this_week=0; $this_month=0;
														foreach($tags['question_tags'] as $qt){
															$question_posted = strtotime(date('Y-m-d',strtotime($qt['question']['created'])));
															if($current_date == $question_posted){$today++;}
															if($question_posted >= $current_week_prev_date && $question_posted <= $current_date){$this_week++;}
															if($question_posted >= $current_month_first_date && $question_posted <= $current_date){$this_month++;}
														}
														if($today > 0){
															echo $today.' today, ';
														}
														if($this_week > 0){
															echo $this_week.' this week, ';
														}
														if($this_month > 0){
															echo $this_month.' this month';
														}
													}
													?>
													</span>
												</div>
					<?php
									$m++;
									if($m==$alphabetic_count){
					?>
											</div>
										</div>
									</div>
					<?php
									}
								}
								//echo '</div>';
							}
						}
					}else{	//if browse by alphabetically
						$cur_date = date('Y-m-d');
						$current_date = strtotime(date($cur_date));
						$cur_week_prev_date = date('Y-m-d', strtotime('-6 days', strtotime($cur_date)));
						$current_week_prev_date = strtotime($cur_week_prev_date);
						
						$cur_month_first_date = date('Y-m-01');
						$current_month_first_date = strtotime($cur_month_first_date);
					?>
							<div class="quetion-lists">
								<div class="Q-left">
									<div class="row">
					<?php
						foreach($sorted_array[$element] as $tags){
					?>
										<div class="col-md-3 col-sm-6">
											<div class="tagsWrap">
												<a href="<?php echo Router::url(array('action'=>'tag/',$tags['slug'], false));?>" class="tags"><span><?php echo $tags['title'];?></span><?php if(!empty($tags['question_tags']))echo ' x'.count($tags['question_tags']);?></a>
											</div>
											<span class="ased_by">
											<?php
											if(!empty($tags['question_tags'])){
												$today=0; $this_week=0; $this_month=0;
												foreach($tags['question_tags'] as $qt){
													$question_posted = strtotime(date('Y-m-d',strtotime($qt['question']['created'])));
													if($current_date == $question_posted){$today++;}
													if($question_posted >= $current_week_prev_date && $question_posted <= $current_date){$this_week++;}
													if($question_posted >= $current_month_first_date && $question_posted <= $current_date){$this_month++;}
												}
												if($today > 0){
													echo $today.' today, ';
												}
												if($this_week > 0){
													echo $this_week.' this week, ';
												}
												if($this_month > 0){
													echo $this_month.' this month';
												}
											}
											?>
											</span>
										</div>
					<?php
						}
					?>
									</div>
								</div>
							</div>
					<?php
					}
					?>
					
					<?php if($element == ''){ ?>
							<div class="loader" id="more_tags_loader">
								<a href="javascript:void(0);" onclick="view_rest_tags();">load more</a>
							</div>
					<?php } ?>
					<?php
					}else{
						echo '<p class="no_results_found">No results found</p>';
					}
					?>
						</div>
					</div>
					<div class="col-md-3 col-sm-4 question-right ">
						<?php echo $this->element('right_panel_2'); ?>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
<script>
function view_rest_tags(){
	$('#more_tags_loader').html('<img src="<?php echo Router::url('/images/loader.gif');?>" alt="" />');
	$('.rest_tags').show(1000);
	$('#more_tags_loader').html('');
}
</script>