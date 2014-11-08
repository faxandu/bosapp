<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Student</th>
					<th>Class</th>
					<th>Start Time</th>
					<th>Log Out</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($students as $student) { ?>
				<tr>
					<td><?= $student->student->first_name . ' ' . $student->student->last_name; ?></td>
					<td><?= $student->class; ?></td>
					<td><?= $student->start_time; ?></td>
					<td><a href="<?php echo URL::to('/group_study/entry/set-end-time/'. $student->id); ?>" class="btn btn-danger">Log Out User</a></td>
				</tr>
				<?php } ?>
		</table>
	</div>
</div>