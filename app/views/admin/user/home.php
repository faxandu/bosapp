Home page for user mamagement. List users?<br><br><br>
<a href = "<?= URL::to('admin/user/create');?>">create user</a><br><br><br>

<form method ="POST" action="<?= URL::to('admin/user/delete')?>">
id<input type="text" name="id">
<input type="submit">
</form>
<?php
	echo Session::get('status');
	echo "<br>";
	foreach($users as $user){
		print_r($user->toarray());
	}

?>