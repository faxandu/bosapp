
<div class="row col-sm-8 col-sm-offset-2">

	<h3>User Summary</h3>

	<hr>

	<a href = "<?= URL::to('/admin/schedule/course-summary');?>">
		<button type="button" class="btn btn-primary btn-sm">Course Summary</button>
	</a>

	<br>

	<hr>

	<p>
	Click on a user to edit their skills.
	</p>


	<br>


	<table class="table table-hover table-striped centerTable">

		<thead>
			<tr>
				<th> Name (username)</th>
				<th> Email </th>
				<th> prefered hours </th>
				<th> Scheduled hours </th>
				<th> courses </th>
				<th> skills </th>
			</tr>
		</thead>

		<tbody>

		<?php

			$trClass = "";
			$clickableTrait = "clickToEditSkills";
			$trDisp = "";


			foreach ($users as $user){

				// if($trDisp == $trClass)
				// 	$trDisp = "";
				// else
				// 	$trDisp = $trClass;

		?>
				<tr class="<?=  $trDisp . " " . $clickableTrait ?>" href="<?= URL::to('/admin/schedule/modify-user') . '?id='. $user->id ?>">
					<td> <?= $user->fullNameWithUsername() ?> </td>
					<td> <?= $user->email ?> </td>
					<td> <?= $user->prefered_hours ?> </td>
					<td> <?= $user->working_hours ?> </td>
					<td> 
				
		<?php

				$courses = $user->courses->sortBy('course_title');
				$skills = $user->skills->sortBy('name');


				foreach($courses as $course){
				
		?>

					<?= $course->course_title ?> 
		<?php

				}

		?>
				</td>
				
				<td> 
				
		<?php

				foreach($skills as $skill){
		
		?>
					<?= $skill->name ?> 

		<?php

				}

		?>
				</td>


		<?php

			}

		?>
		</tbody>

	</table>

</div>
