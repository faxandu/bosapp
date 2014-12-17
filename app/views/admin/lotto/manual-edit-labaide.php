<div class="row col-sm-6 col-sm-offset-3">

	<h3> Update <?= $course->course_title . " " . $course->crn ?> </h3>


	<a href = "<?= URL::to('/admin/schedule/home');?>">
		<button type="button" class="btn btn-primary btn-xs">Schedule home</button>
	</a>

	<br>

	<br>

	<form method='POST' action='<?= URL::to('/admin/schedule/course/set-labaide'); ?>'>

		<table>
			<thead>


			</thead>


			<tbody>

				<tr>
					<td> Labaide </td>
					<td>
						<select name="user" class="form-control">
						<?php

						foreach($labaides as $labaide){


						?>
						
							<option value="<?= $labaide->id ?>" > <?= $labaide->getFullNameWithUsername() ?></option>

						<?php

						}


						?>
						</select>
					</td>

				</tr>

			</tbody>


		</table>

		<input type="hidden" name="course" value="<?= $course->id ?>">
		<input type="submit" value="Update" class="btn btn-default">

	</form>

</div>
