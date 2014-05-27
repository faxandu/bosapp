list of all labaides and their courses
<br>

<pre>
<?php
	
	foreach($users as $user){

		$user->courses->toArray();
		$user->skills->toArray();
		print_r($user->toarray());

	}
	

?>

</pre>