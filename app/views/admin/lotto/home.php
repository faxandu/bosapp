<div class="row col-sm-6 col-sm-offset-3">
	
	<a href = "<?= URL::to('/admin/schedule/scheduler');?>">
		<button type="button" class="btn btn-primary">Run Scheduler</button>
	</a>

	<a href = "<?= URL::to('admin/schedule/user-list');?>">
		<button type="button" class="btn btn-primary">User skills</button>
	</a>

	<a href = "<?= URL::to('/admin/schedule/import');?>">
		<button type="button" class="btn btn-primary">Import Courses</button>
	</a>

	<br> <br>

	<br> <br>

	<br> <br>


	<table class="table table-striped table-hover">

		<thead>
			<tr>
				<th>Course</th>
				<th>Course number</th>

				<th>LabAide</th>
			</tr>
		</thead>


		<tbody>

		<?php

			foreach($courses as $course){
			
				if(empty($course->labaides->toarray()))
					$labaide = "none";
				else
					$labaide = $course->labaides()->firstorfail()->getFullNameWithUsername();
				

		?>
			
			<tr class="clickablerow" href="<?= URL::to('/admin/schedule/manual-assign') . '?id='. $course->id ?>">
				<td> <?= $course->course_title ?> </td>
				<td> <?= $course->course_number ?> </td>
				<td> <?= $labaide ?> </td>
			</tr>
			
		<?php

			}
		?>

		</tbody>

	</table>

</div>