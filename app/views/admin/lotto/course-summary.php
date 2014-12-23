
<div class="row col-sm-8 col-sm-offset-2">
	

	<h3>Course Summary</h3>
		
	<hr>

	<div>


		<div class="left">


			<a href = "<?= URL::to('admin/schedule/user-summary');?>">
				<button type="button" class="btn btn-primary btn-sm">User Summary</button>
			</a>


		</div>



		<div class="right">

			<a href = "<?= URL::to('/admin/schedule/scheduler');?>">
				<button type="button" class="btn btn-primary btn-sm">Run Scheduler</button>
			</a>

			<a href = "<?= URL::to('/admin/schedule/import');?>">
				<button type="button" class="btn btn-primary btn-sm">Import Courses</button>
			</a>

			<a href = "<?= URL::to('admin/schedule/reset-semester');?>">
				<button type="button" class="btn btn-danger btn-sm">Reset Semester</button>
			</a>
			
			<a href = "<?= URL::to('admin/schedule/lock-availability');?>">
				<button type="button" class="btn btn-danger btn-sm">Lock Availability</button>
			</a>

		</div>
			
	</div>

	<br>
	<br>
	<hr>

	<p>
	Click on a course to set/remove the labaide or edit certain info.
	</p>


	<table class="table table-striped table-hover centerTable">

		<thead>
			<tr>
				<th>Course</th>
				<th>CRN</th>
				<th>Course number</th>
				<th>Times</th>
				<th>Days of Week</th>

				<th>Labaide</th>
				<th>Needs Coverage</th>
			</tr>
		</thead>


		<tbody>

		<?php

			foreach($courses as $course){
			
				if(empty($course->labaides->toarray()))
					$labaide = "none";
				else
					$labaide = $course->labaides()->firstorfail()->fullNameWithUsername();
				

		?>
			
			<tr class="clickablerow" href="<?= URL::to('/admin/schedule/manual-assign') . '?id='. $course->id ?>">
				<td> <?= $course->course_title ?> </td>
				<td> <?= $course->crn ?> </td>
				<td> <?= $course->course_number ?> </td>
				<td> <?= $course->start_time . " - " . $course->end_time ?> </td>
				<td> <?= $course->days_of_week ?> </td>
				<td> <?= $labaide ?> </td>
				<td> 

				<?php

					if($course->needs_coverage){



				?>

					<span class="glyphicon glyphicon-ok"></span>

				<?php

					}
				?>

				</td>
			</tr>
			
		<?php

			}
		?>

		</tbody>

	</table>

</div>