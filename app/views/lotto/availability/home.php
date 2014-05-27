My availability<br>
<a href = "<?= URL::to('schedule/availability/create'); ?>">update my availability</a><br>


<br>

<form method ="POST" action="<?= URL::to('schedule/availability/delete')?>">
delete by id<input type="text" name="id">
<input type="submit">
</form>

<pre>
<?php
	print_r(@Session::get('error'));


	echo $user->username;
	echo "<br>";
	print_r(Auth::user()->availability->toarray());


?>

</pre>