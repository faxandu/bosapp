<h3>Fill out the details below</h3>
<?php
	
	if(!isset($user)){
		$user = new User();
		$action = "create";
	}
	else{
		$action = "update";
	}
?>
<form method='POST' action='<?= $action ?>'>
	<table border = "3">
		<input type="hidden" name="id" value="<?= $user->id ?>"/>
		<tr>
			<td> User Name </td>
			<td> <input type="text" name="username" value="<?= $user->username ?>"/> </td>
		</tr>

		<tr>
			<td> First Name </td>
			<td> <input type="text" name="first_name" value="<?= $user->first_name ?>"/> </td>
		</tr>
		<tr>
			<td> Password </td>
			<td> <input type="password" name="password"/> </td>
		</tr>

	</table>
	<input type="submit" value="Create"/>
</form>