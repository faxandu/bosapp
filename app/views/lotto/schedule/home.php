
<div class="row col-sm-6 col-sm-offset-3">

	<h3> My schedule </h3>

	<p>Below are the classes you will be labaiding in for this semester.</p>
	<br>

	
	<table class="table table-striped table-hover centerTable">

		<thead>
			<tr>
				<th>Course Title</th>
				<th>Course Number</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th>Days of Week</th>
				
			</tr>
		</thead>


		<tbody>
		<?php

			foreach($userCourses as $course){
			
			//print_r();
			//print_r($course);
		?>
			<tr>
				<td> <?= $course->course_title ?> </td>
				<td> <?= $course->course_number ?> </td>
				<td> <?= $course->start_time ?> </td>
				<td> <?= $course->end_time ?> </td>
				<td> <?= $course->days_of_week ?> </td>

			</tr>
		
		<?php

			}
		?>

		</tbody>

	</table>
</div>
