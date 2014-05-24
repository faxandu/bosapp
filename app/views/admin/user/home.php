Home page for user mamagement. List users?<br><br><br>
<a href = "<?= URL::to('admin/user/create');?>">create user</a><br><br><br>

<form method ="POST" action="<?= URL::to('admin/user/delete')?>">
delete by id<input type="text" name="id">
<input type="submit">
</form>

<pre>
<?php
	echo Session::get('status');
	echo "<br>";
	foreach($users as $user){
		print_r($user->toarray());
	}

?>

</pre>