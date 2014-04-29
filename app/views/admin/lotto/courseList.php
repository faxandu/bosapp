
list all courses and lab aides assigned. Perhaps highlight ones with no lab aide /sort

<br>

Canceled courses: <?= @$canceled ?> <br>
updated courses: <?= @$updated ?> <br>
New courses: <?= @$created ?> <br>
<a href="<?= URL::to('/admin/schedule/course/import'); ?>"> call import function here? </a>

<br>

<a href="<?= URL::to('/admin/schedule/course/assign-labaides'); ?>"> call assign lab aides here? </a>

<br>

delete a course
<form method='POST' action="<?= URL::to('/admin/schedule/course/delete'); ?>">
<input type="text" name="id"><br>
<input type="submit">
</form>


<br>

<br><br>


<table id="courseTable" border="1">
<thead>
	<tr>
		<th>Course Title</th>
		<th>Course Num</th>
		<th>Lab Aide name</th>
	</tr>
</thead>
<tbody>
<?php

	//echo $created;
	foreach($courses as $course){
		echo "<tr>";
			echo "<td>";
			echo $course->course_title;
			echo "</td>";

			echo "<td>";
			echo $course->course_num;
			echo "</td>";

			echo "<td>";
			echo @$course->labaides()->first()->username;
			echo "</td>";

		echo "</tr>";
		

	}

?>	

</tbody>

</table>

