<html>
<?php

// try{
// 	$user = User::findOrFail(1);
// 	$skill = Skill::findOrFail(1);
// }catch(Exception $e){
// 	$course = new User;
// 	$skill = new Skill;
// }

?>

<form action="setUserStaff" method= 'POST'>
<table>


<tr><td> user: </td><td> <input type="text" name = "user_id" > </td></tr>
<tr><td> staff: </td><td> <input type="text" name = "staff_id" > </td></tr>


</table>
<input type="submit" value="submit">
</form>




</html>