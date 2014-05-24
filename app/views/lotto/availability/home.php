My availability<br>
<a href = "<?= URL::to('schedule/availability/create-page'); ?>">update my availability</a><br>


<br>
<?php
	print_r(@Session::get('error'));


	echo $user->username;
	echo "<br>";
	print_r(Auth::user()->availability->toarray());


?>