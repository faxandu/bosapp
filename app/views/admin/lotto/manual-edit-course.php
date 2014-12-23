<div class="row col-sm-6 col-sm-offset-3">

	
	<h3> Update <?= $course->course_title . " " . $course->crn ?> </h3>




	<a href = "<?= URL::to('/admin/schedule/course-summary');?>">
		<button type="button" class="btn btn-primary btn-sm">Course Summary</button>
	</a>

	<br>

	<br>

	<div class="left">
		<div>
			<form method='POST' action='<?= URL::to('/admin/schedule/course/remove-labaide'); ?>'>

				<table class="table">
					<thead>
						<th>Remove</th>
						<th></th>
					</thead>

					<tbody>			
						
						<tr>
							<td>labAide:</td>
							<td>				
								
								<select name="user" class="form-control">
								<?php 
								
								if($currAide)
									foreach($currAide as $labaide){
							
								?>
							
									<option value="<?= $labaide->id ?>" > <?= $labaide->fullNameWithUsername() ?></option>

								<?php 

									}
									else{
								?>

									<option value="<?= "" ?>" > <?= "" ?></option>
								<?php
									}

								?>

								</select>
							</td>
						</tr>
					
						<tr>
							<td></td>
							<td>
								<input type="hidden" name="course" value="<?= $course->id ?>">
								<input type="submit" value="Remove" class="btn btn-default">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div>
			<form method='POST' action='<?= URL::to('/admin/schedule/course/set-labaide'); ?>'>

				<table class="table">
					<thead>
						<th>Assign</th>
						<th></th>
					</thead>

					<tbody>			
						
						<tr>
							<td>labAide:</td>
							<td>				
								
								<select name="user" class="form-control">
								<?php 
								
								foreach($labaides as $labaide){
							
								?>
							
								<option value="<?= $labaide->id ?>" > <?= $labaide->fullNameWithUsername() ?></option>

								<?php 

									}

									?>

									</select>
							</td>
						</tr>
						
						<tr>
							<td></td>
							<td>
								<input type="hidden" name="course" value="<?= $course->id ?>">
								<input type="submit" value="Add" class="btn btn-default">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>


	<div class="right">
		<div>
			<form method='POST' action='<?= URL::to('/admin/schedule/course/update-course-needs-coverage'); ?>'>
				<table class="table">
					<thead>
						<th>Needs Coverage?</th>
						<th></th>
					</thead>

					<tbody>				
						<tr>
							<td>Yes/No:</td>
							<td>				
								
								<select name="coverage" class="form-control">
								
								<?php 
								
								if($course->needs_coverage){

								?>
									<option value="<?= "true" ?>" > <?= "Yes" ?></option>
									<option value="<?= "false" ?>" > <?= "No" ?></option>
								<?php
								} else {
								?>

									<option value="<?= "false" ?>" > <?= "No" ?></option>
									<option value="<?= "true" ?>" > <?= "Yes" ?></option>
									

								<?php
								}
								?>
								
								
								</select>
							</td>
						</tr>
					
						<tr>
							<td></td>
							<td>
								<input type="hidden" name="course" value="<?= $course->id ?>">
								<input type="submit" value="Update" class="btn btn-default">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>

		<div>
			<form method='POST' action='<?= URL::to('/admin/schedule/course/set-labaide'); ?>'>
				<table class="table">
					<thead>
						<th>Manual Override</th>
						<th></th>
					</thead>

					<tbody>			
						
						<tr>
							<td>labAide:</td>
							<td>				
								
								<select name="user" class="form-control">
								<?php 
								
								foreach($allLabaides as $labaide){
							
								?>
							
								<option value="<?= $labaide->id ?>" > <?= $labaide->fullName() ?></option>

								<?php 

									}

									?>

									</select>
							</td>
						</tr>
						
						<tr>
							<td></td>
							<td>
								<input type="hidden" name="course" value="<?= $course->id ?>">
								<input type="submit" value="Add" class="btn btn-default">
							</td>
						</tr>
					</tbody>
				</table>
			</form>

		</div>
	</div>
</div>

