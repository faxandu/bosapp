<style>
#navigation {display: none !important;}
</style>
<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<h2>Welcome New Student</h2>
		<p>This is your first time using our new Group Study sign-in system. Please fill out the following form. After you complete this form, you will be able to sign in to group study sessions just by swiping your Student ID</p>

		<form method="post" action="<?php echo URL::to('/group_study/entry/add-student'); ?>">
			<div class="form-group">
				<label for="first_name">First Name</label>
				<input type="text" name="first_name" class="form-control" />
			</div>
			<div class="form-group">
				<label for="last_name">Last Name</label>
				<input type="text" name="last_name" class="form-control" />
			</div>
			<input type="hidden" name="student_num" value="<?php echo $student_num; ?>" />
			<input type="hidden" name="class" value="<?php echo $class; ?>" />
			<input type="submit" name="submit" value="Sign In" class="btn btn-primary" />
		</form>
	</div>
</div>