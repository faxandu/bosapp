
<div class="row col-sm-6 col-sm-offset-3">

	<h3> User info </h3>


	<a href = "<?= URL::to('/admin/schedule/home');?>">
		<button type="button" class="btn btn-primary btn-xs">Schedule home</button>
	</a>

	<br>
	<p>
	Click on user to edit their skills.
	</p>
	<br>


	<table class="table table-hover">

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

			$trClass = "stripe";
			$clickableTrait = "clickToEditSkills";
			$trDisp = "";


			foreach ($users as $user){

				if($trDisp == $trClass)
					$trDisp = "";
				else
					$trDisp = $trClass;

		?>
				<tr class="<?=  $trDisp . " " . $clickableTrait ?>" href="<?= URL::to('/admin/schedule/skill/assign-skills') . '?id='. $user->id ?>">
					<td> <?= $user->getFullNameWithUsername() ?> </td>
					<td> <?= $user->email ?> </td>
					<td> <?= $user->prefered_hours ?> </td>
					<td> <?= $user->working_hours ?> </td>


		<?php

				$courses = $user->courses;
				$skills = $user->skills;

				$count = 0;
				while($courses->count() > 0 || $skills->count() > 0){

					$course = $courses->shift(); 
					$skill = $skills->shift();
					


					if($count != 0){

		?>

						<tr class="<?=  $trDisp . " " . $clickableTrait ?>" href="<?= URL::to('/admin/schedule/skill/assign-skills') . '?id='. $user->id ?>">
							<td></td>
							<td></td>
							<td></td>
							<td></td>

							<td> <?= ($course) ? $course->course_title : "" ?> </td>
							<td> <?= ($skill) ? $skill->name : "" ?> </td>


						</tr>

		<?php

					} else {
						$count++;
		?>

						<td> <?= ($course) ? $course->course_title : "" ?> </td>
						<td> <?= ($skill) ? $skill->name : "" ?> </td>
					</tr>


		<?php

				}
			}

		}
		?>

		</tbody>

	</table>

</div>
