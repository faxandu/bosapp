<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Pay Period</th>
					<th>Start Date</th>
					<th>End Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($pay_periods as $period) { ?>
				<tr>
					<td><a href="<?php echo URL::to('time/entries/entries/' . $period->id); ?>" style="display:block; color:#fff;"><?php echo $period->id; ?></a></td>
					<td><?php echo $period->start_pay_period; ?></td>
					<td><?php echo $period->end_pay_period; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

