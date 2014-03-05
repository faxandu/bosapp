<html>

<?php 
try{
	$course = Course::findOrFail(4);
}catch(Exception $e){
	$course = new Course;
	$course->labAide = NULL;
}

?>


<form action="lotto/createCourse" method= 'POST'>
<table>
<!--<tr><td> id: </td><td> <input type="text" name = "id" value="<?=$course->id?>"> </td></tr> -->
<!--<tr><td> labAide: </td><td> <input type="text" name = "labAide" value="<?=$course->labAide ?>"> </td></tr> -->
<tr><td> Name: </td><td> <input type="text" name = "name" value="<?=$course->name?>"> </td></tr>
<tr><td> crn: </td><td> <input type="text" name = "crn" value="<?=$course->crn?>"> </td></tr>
<tr><td> creditHour: </td><td> <input type="text" name = "creditHour" value="<?=$course->creditHour?>"> </td></tr>
<tr><td> endTime: </td><td> <input type="time" name = "endTime" value="<?=$course->endTime?>"> </td></tr>
<tr><td> startTime: </td><td> <input type="time" name = "startTime" value="<?=$course->startTime?>"> </td></tr>
<tr><td> endDate: </td><td> <input type="date" name = "endDate" value="<?=$course->endDate?>"> </td></tr>
<tr><td> startDate: </td><td> <input type="date" name = "startDate" value="<?=$course->startDate?>"> </td></tr>

</table>
<input type="submit" value="submit">
</form>



<?php


// $course = new Course;
// echo Form::open(array('route' => 'getCourse'));
// //echo Form::model($course, array('route' => array('setCourse', $course->id)));
// echo Form::label('id', 'Course Name');
// echo Form::text('id');

// $course = new Course;

// Form::close();


?>



<!--
<form method="post">

First name: <input type="text" name = "name"> <br>
<input type="submit" value="submit">
</form> 