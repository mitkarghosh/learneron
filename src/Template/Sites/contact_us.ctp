<?php use Cake\Routing\Router; ?>
<div class="genpage-user-system">
    <div class="container">
		<div class="reset-pass-box contact-us-wrapper">
			<h1>Contact Us</h1>      	   
			<?php echo $this->Flash->render();?>
      	   	<?php echo $this->Form->create($contact, ['id'=>'contact_us_form', 'novalidate' => 'novalidate', 'enctype'=>'multipart/form-data']);?>
      	   	<div class="row">
      	   		<div class="col-md-4">
      	   			<label for="">Your Name <sup>*</sup></label>
      	   		</div>
      	   		<div class="col-md-8">
      	   			<div class="form-group"><?php echo $this->Form->input('name', ['required' => true, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Name' ]); ?></div>
      	   		</div>      	   		
      	   		<div class="col-md-4">
      	   			<label for="">User Name <sup>*</sup></label>
      	   		</div>
      	   		<div class="col-md-8">
      	   			<div class="form-group"><?php echo $this->Form->input('user_name', ['required' => true, 'label' => false, 'class' => 'form-control', 'placeholder' => 'User Name' ]); ?></div>
      	   		</div>
      	   		<div class="col-md-4">
      	   			<label for="">Email <sup>*</sup></label>
      	   		</div>
      	   		<div class="col-md-8">
      	   			<div class="form-group"><?php echo $this->Form->input('email', ['type'=>'email', 'required' => true, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Email' ]); ?></div>
      	   		</div>
      	   		<div class="col-md-4">
      	   			<label for="">Phone Number</label>
      	   		</div>
      	   		<div class="col-md-8">
      	   			<div class="form-group"><?php echo $this->Form->input('phone_number', ['required' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Phone Number' ]);?></div>
      	   		</div>      	   		
      	   		<div class="col-md-4">
      	   			<label for="">Subject</label>
      	   		</div>
      	   		<div class="col-md-8">
      	   			<div class="form-group"><?php echo $this->Form->input('subject', ['required' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Subject' ]);?></div>
      	   		</div>      	   		
      	   		<div class="col-md-4">
      	   			<label for="">Message<sup>*</sup></label>
      	   		</div>
      	   		<div class="col-md-8">
					<div class="form-group"><?php echo $this->Form->input('message', ['type'=>'textarea', 'required' => true, 'label' => false, 'class' => 'form-control', 'placeholder' => 'Message' ]);?></div>
      	   		</div>
      	   	</div>
      	   	<div class="button-set text-center">
      	   		<input type="submit" value="Submit" class="btn-normal">
      	   	</div>      	   
			<?php echo $this->Form->end();?>
		</div>      
		<div class="gen-link">
			<p>You can contact us directly on <a href="mailto:administrator@learneron.net">administrator@learneron.net</a></p>
		</div>      
	</div>
</div>
<script type="text/javascript">
$('#contact_us_form').validate({
	rules: {
		name: 'required',
	}
});
//$(document).ready(function(){
	setTimeout(function(){
		$('#contact_us_form').reset();
		$('.success').remove();
	},5000);	
//});
</script>