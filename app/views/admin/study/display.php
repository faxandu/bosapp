<center><h1>Group Study Reports</h1></center>
<div class="row">
	<div class="col-sm-4 col-sm-offset-4">
		<h2>Refine Report</h2>
		<form method="get" action="<?php echo URL::to('/group_study/report/report'); ?>">
			<div class="form-group">
				<label for="start_date">Start Date</label>
				<input type="test" id="start_date" class="form-control" name="start_date" />
			</div>
			<div class="form-group">
				<label for="end_date">End Date</label>
				<input type="test" id="end_date" class="form-control" name="end_date" />
			</div>
			<div class="form-group">
				<label for="type">Report Type</label>
				<select name="type" class="form-control">
					<option value="date">By Dates</option>
					<option value="class">By Dates/Class</option>
					<option value="student">By Dates/Student ID</option>
				</select>
			</div>
			<div class="form-group">
				<label for="class">Class</label>
				<input type="text" class="form-control" name="class" />
			</div>
			<div class="form-group">
				<label for="student_id">Student ID</label>
				<input type="text" class="form-control" name="student_id" />
			</div>
			<input type="submit" name="submit" class="btn btn-primary" value="Refine" />
		</form>
	</div>
</div>

</br></br>


<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<h2>Group Study Entries</h2>

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Date</th>
					<th>Student</th>
					<th>Class</th>
					<th>In</th>
					<th>Out</th>
					<th>Facilitator</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($entries as $entry) {
 ?>
				<tr>
					<td><?php echo $entry->date; ?></td>
					<td><?php echo $entry['student']['first_name'] . ' ' . $entry['student']['last_name']; ?></td>
					<td><?php echo $entry->class; ?></td>
					<td><?php echo date('h:ia', strtotime($entry->start_time. ' -4 hours'));  ?></td>
					<td><?php echo date('h:ia', strtotime($entry->end_time. ' -4 hours')); ?></td>
					<td><?php echo $entry->facil->first_name . ' ' . $entry->facil->last_name; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</br></br>

<script>
$(function() {
  $('#start_date').datetimepicker({
    timepicker: false,
    format: 'Y-m-d',
    todayButton: true,
  });
  $('#end_date').datetimepicker({
    timepicker: false,
    format: 'Y-m-d',
    todayButton: true,
  });

})
</script>
