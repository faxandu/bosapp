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
					<td><?php echo $entry->student->first_name . ' ' . $entry->student->last_name; ?></td>
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
<div class="row">
	<div class="col-sm-8 col-sm-offset-1">
		<a href="<?php echo URL::to('/group_study/report/excel-export'); ?>" class="btn btn-success">Download Excel Spreadsheet</a>
