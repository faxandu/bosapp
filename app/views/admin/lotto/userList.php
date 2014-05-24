list all labaides
<br>
<?php
	
	foreach($users as $user){

		$user->courses->toArray();
		echo $user->username . " " . $user->courses->count();
		echo "<br>";

	}
	

?>