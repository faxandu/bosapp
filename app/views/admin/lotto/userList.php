list all labaides
<br>
<?php
	
	foreach($users as $user){

		Lotto\models\Course::find(1)->setLabaide($user);
		$user->courses->toArray();
		echo $user->username . " " . $user->courses->count();
		echo "<br>";

	}
	

?>