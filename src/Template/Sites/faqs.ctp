<div class="genpage-user-system">
    <div class="container">
		<div class="title">
			<h1>Frequently Asked Questions</h1>
		</div>
		<div class="genpage-wrapper about-wrapper">
		<?php
		if(!empty($faqs_data)){		
		?>
			<div class="toggle_wrap">
		<?php
			foreach($faqs_data as $key_fq => $fq){
		?>
				<div class="toggle_block<?php if($key_fq==0){echo ' opened';}?>">
					<div class="ques">
						<h4 class="faq_q"><?php echo $fq->question; ?></h4>
					</div>
					<div class="ans_toggle" <?php if($key_fq==0){echo 'style="display: block"';}?>>
						<?php echo $fq->answer;?>
					</div>
				</div>
		<?php
			}
		?>
			</div>
		<?php
		}else{echo 'No results found.';}
		?>
		</div>
    </div>
</div>
<script type="text/javascript">
	$(".toggle_block > .ques").bind("click", function () {
		if ($(this).parent().hasClass('opened')) {
			$(".toggle_block").removeClass('opened');
			$(".toggle_block").children(".ans_toggle").slideUp(300);
			$(this).parent().removeClass('opened');
			$(this).next('.ans_toggle').slideUp(300);
			return false;
		} else {
			$(".toggle_block").removeClass('opened');
			$(".toggle_block").children(".ans_toggle").slideUp(300);
			$(this).parent().addClass('opened');
			$(this).next('.ans_toggle').slideDown(300);
			return false;
		}
	});
</script>