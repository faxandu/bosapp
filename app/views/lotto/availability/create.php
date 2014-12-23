<div class="row col-sm-6 col-sm-offset-3">

	<h3> Update Availability </h3>


	<br>

		<p> Fill out the following feilds to add to your availability. This is for the time you are able work.</p>

	<br>
	<form method='POST' action='<?= URL::to('/schedule/availability/create'); ?>'>

		<table>
			<thead>


			</thead>


			<tbody>

				<tr>
					<td>Pick the Day of Week: </td>
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
					<td>Enter the start Time: </td>
					<td><input text="text" name="start_time" class="form-control" placeholder="ie: 17:45 or 5:45pm"></td>
				</tr>
				
				<tr>
					<td>Enter the end Time: </td>
					<td><input text="text" name="end_time" class="form-control" placeholder="ie: 18:45 or 6:45pm"></td>
				</tr>

			</tbody>


		</table>
	<input type="hidden" name="user_id" value="<?= Auth::user()->id ?>">
	<input type="submit" value="Add" class="btn btn-default">

	</form>

</div>
