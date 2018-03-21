<div class="Q_filter">
	<span>Questions Per Page</span>
	<select name="" id="no_of_questions">
		<option value="">Select</option>
		<option value="12" <?php if(isset($_GET['limit']) && $_GET['limit']==12)echo 'selected';?>>12</option>
		<option value="16" <?php if(isset($_GET['limit']) && $_GET['limit']==16)echo 'selected';?>>16</option>
		<option value="18" <?php if(isset($_GET['limit']) && $_GET['limit']==18)echo 'selected';?>>18</option>
	</select>
</div>