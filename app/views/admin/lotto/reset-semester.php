<div class="row col-sm-6 col-sm-offset-3">

	<h1> Are you sure you want to reset the semester schedule?</h1>

	<h3>This will delete all the courses and users availabilities</h3>



	<form method='POST' action='<?= URL::to('/admin/schedule/reset-semester'); ?>'>

		<input type="hidden" name="delete" value="yes">
		<input type="submit" value="Delete All" class="btn btn-warning">


		<a href = "<?= URL::to('/admin/schedule/course-summary');?>">
			<button type="button" class="btn btn-success">No</button>
		</a>
	</form>


</div>

