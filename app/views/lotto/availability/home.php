<?php


?>


<div class="row col-sm-6 col-sm-offset-3">

	<h3> My availability </h3>


	<a href = "<?= URL::to('schedule/availability/create'); ?>">
		<button type="button" class="btn btn-primary" >add to availability</button>
	</a>

	<br>
	<br>


	<p>You may set a number of hours as your prefered max working hours. No more than 20 !!!!.</p>
	<p>We will try to reach this number if possible.</p>
	<form method='POST' action='<?= URL::to('/schedule/user/update-prefered-hours'); ?>'>
		<?php

		?>

		<input type="text" name="hours" value="<?= $user->prefered_hours  ?>">

		<input type="hidden" name="user" value="<?= $user->id ?>">
		<input type="submit" value="Update" class="btn btn-default">

	</form>
	

	<br>


	<br>

	<p> Below you will find your current availability.</p>
	<table class="table centerTable">

		<thead>
			<tr> 
				<th>Day of week </th>
				<th>Start Time</th>
				<th>End Time</th>
				<th></th>
				<th></th>
			</tr>
		</thead>

		<tbody class="table-striped">

	<?php
		
		foreach($user->availability->toarray() as $availability){
			//print_r($availability);
	?>
			<tr>
				<td> <?= $availability['day_of_week'] ?> </td>
				<td> <?= $availability['start_time'] ?> </td>
				<td> <?= $availability['end_time'] ?> </td>
				<td>  <a href="<?= URL::to('schedule/availability/delete?id='. $availability['id'])  ?>" ><span class="glyphicon glyphicon-remove" > </span> </a> </td>
				<td>  <a href="<?= URL::to('schedule/availability/update?id='. $availability['id'])  ?>" ><span class="glyphicon glyphicon-pencil" > </span> </a> </td>
			</tr>

	<?php

		}
	?>
		</tbody>


	</table>
</div>
