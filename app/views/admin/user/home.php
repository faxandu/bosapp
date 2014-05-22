Home page for user mamagement. List users?
<a href = "<?= URL::to('admin/user/create');?>">create user</a><br>
<?php
	
	foreach($users as $user){
		print_r($user->toarray());
	}

?>