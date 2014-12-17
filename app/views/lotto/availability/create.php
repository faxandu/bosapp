<div class="row col-sm-6 col-sm-offset-3">

	<h3> Update Availability </h3>

	<form method='POST' action='<?= URL::to('/schedule/availability/create'); ?>'>

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
							"Th" => "Thursday",
							"F" => "Friday",
							"S" => "Saturday"
							);
						foreach($selectOptions as $option => $displayVal){


						?>
						
							<option value="<?= $option ?>"> <?= $displayVal ?></option>

						<?php

						}


						?>
						</select>
					</td>

				</tr>
				
				<tr>
					<td> Start Time </td>
					<td><input text="text" name="start_time" class="form-control" placeholder="24/h format"></td>
				</tr>
				
				<tr>
					<td> End Time </td>
					<td><input text="text" name="end_time" class="form-control" placeholder="24/h format"></td>
				</tr>

			</tbody>


		</table>

	<input type="submit" value="Add" class="btn btn-default">

	</form>

</div>
