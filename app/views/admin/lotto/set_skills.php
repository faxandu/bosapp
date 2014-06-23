set skills:

<form method ="POST" action="<?= URL::to('admin/schedule/user/set-skills');?>">

user id<input type="text" name="user"><br>
skill id<input type="text" name="skill"><br>

<input type="submit">


</form>

<pre>
<?php
	use Lotto\models\Skill;
	//echo $created;
	foreach(User::all() as $course){
		

		print_r($course->toarray());
		

	}

	echo "<br>";
foreach(Skill::all() as $course){
		

		print_r($course->toarray());
		

	}



?>	
</pre>