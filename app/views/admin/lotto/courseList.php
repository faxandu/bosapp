
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


<pre>
<?php
	use Lotto\models\Skill;
	//echo $created;
	foreach($courses as $course){
		

		print_r($course->toarray());
		

	}

	echo "<hr>";
foreach(Skill::all() as $course){
		

		print_r($course->toarray());
		

	}



?>	
</pre>



