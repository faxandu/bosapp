<html>
<?php

try{
	$course = Staff::findOrFail(1);
}catch(Exception $e){
	$course = new Staff;
	
}

?>

<form action="setStaff" method= 'POST'>
<table>


<tr><td> id: </td><td> <input type="text" name = "id" value="<?=$course->id?>"> </td></tr>
<tr><td> Type: </td><td> <input type="text" name = "type" value="<?=$course->type?>"> </td></tr>


</table>
<input type="submit" value="submit">
</form>




</html>