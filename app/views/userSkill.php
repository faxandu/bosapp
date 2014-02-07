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

<form action="setUserSkill" method= 'POST'>
<table>


<tr><td> user: </td><td> <input type="text" name = "user_id" > </td></tr>
<tr><td> skill: </td><td> <input type="text" name = "skill_id" > </td></tr>


</table>
<input type="submit" value="submit">
</form>




</html>