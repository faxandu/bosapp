<html>
<?php

try{
	$course = StaffType::findorFail(1);


}catch(Exception $e){
	$course = new StaffType;
	
}

?>

<form action="setStaff" method= 'POST'>
<table>


<tr><td> id: </td><td> <input type="text" name = "id" value="<?=$course->id?>"> </td></tr>
<tr><td> Type: </td><td> <input type="text" name = "staffType" value="<?=$course->type?>"> </td></tr>


</table>
<input type="submit" value="submit">
</form>




</html>