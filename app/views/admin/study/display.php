<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<h2>Group Study Entries</h2>

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Student</th>
					<th>Class</th>
					<th>In</th>
					<th>Out</th>
					<th>Facilitator</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($entries as $entry) { ?>
				<tr>
					<td><?php $entry->student->first_name . ' ' . $entry->student->last_name; ?></td>
					<td><?php echo $entry->class; ?></td>
					<td><?php echo $entry->start_time; ?></td>
					<td><?php echo $entry->end_time; ?></td>
					<td><?php echo $entry->facil->first_name . ' ' . $entry->facil->last_name; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

	</div>
</div>