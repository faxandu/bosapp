<html>
<?php

try{
	$course = User::findOrFail(1);
}catch(Exception $e){
	$course = new User;
	
}

?>

<form action="setUser" method= 'POST'>
<table>


<tr><td> id: </td><td> <input type="text" name = "id" value="<?=$course->id?>"> </td></tr>
<tr><td> Name: </td><td> <input type="text" name = "name" value="<?=$course->name?>"> </td></tr>


</table>
<input type="submit" value="submit">
</form>




</html>