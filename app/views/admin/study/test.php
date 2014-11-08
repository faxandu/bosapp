<html>
<head>
	<title></title>
</head>
<body>
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