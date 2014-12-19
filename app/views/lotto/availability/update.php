<div class="row col-sm-6 col-sm-offset-3">

	<h3> Update Availability </h3>

	<form method='POST' action='<?= URL::to('/schedule/availability/update'); ?>'>

		<table>
			<thead>


			</thead>


			<tbody>

				<tr>
					<td> Day of Week </td>
					<td>
						<select name="day_of_week" class="form-control">
						<?php

						$selectOptions = array(
							"M" => "Monday",
							"Tu" => "Tuesday",
							"W" => "Wednesday",
							"R" => "Thursday",
							"F" => "Friday",
							"S" => "Saturday"
							);
						foreach($selectOptions as $option => $displayVal){


						?>
						
							<option value="<?= $option ?>" <?= ($userAvailability->day_of_week == $option) ? 'selected="selected"' : "" ?>> <?= $displayVal ?></option>

						<?php

						}


						?>
						</select>
					</td>

				</tr>
				
				<tr>
					<td> Start Time </td>
					<td><input text="text" name="start_time" class="form-control"  <?= ($userAvailability->start_time) ? 'value="' . $userAvailability->start_time . '"' : 'placeholder="24/h format"' ?>></td>
				</tr>
				
				<tr>
					<td> End Time </td>
					<td><input text="text" name="end_time" class="form-control"  <?= ($userAvailability->end_time) ? 'value="' . $userAvailability->end_time . '"' : 'placeholder="24/h format"' ?>></td></td>
				</tr>

			</tbody>


		</table>
	<input type="hidden" name="id" value="<?= $userAvailability->id ?>">
	<input type="submit" value="Update" class="btn btn-default">

	</form>



	<hr>

</div>
