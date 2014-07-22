
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Date</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Duration</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($entries as $entry) { ?>
				<tr>
					<td><?= $entry->startDate; ?></td>
					<td><?= $entry->startTime; ?></td>
					<td><?= $entry->endTime; ?></td>
					<td><?= $entry->endTime - $entry->startTime; ?></td>
					<td></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<button class="btn btn-success" data-toggle="modal" data-target="#timeEntry">Add Time Entry</button>
	</div>
</div>

<div class="modal fade" id="timeEntry">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Time Entry</h4>
      </div>
      <form role="form" method="post" action="<?php echo URL::to('time/entries/create'); ?>" >
      <div class="modal-body">
      	<div class="form-group">
        	<label for="start_time">Category</label>
        	<select name="category_id" class="form-control">
        		<?php foreach ($categories as $category) { ?>
        		<option value="<?= $category->id; ?>"><?= $category->category; ?></option>
        		<?php } ?>
        	</select>
        </div>
        <div class="form-group">
        	<label for="start_date">Start Date</label>
        	<input type="date" class="form-control" name="start_date" />
        </div>
        <div class="form-group">
        	<label for="start_time">Start Time</label>
        	<input type="time" class="form-control" name="start_time" />
        </div>
        <div class="form-group">
        	<label for="end_date">End Date</label>
        	<input type="date" class="form-control" name="end_date" />
        </div>
        <div class="form-group">
        	<label for="end_time">End Time</label>
        	<input type="time" class="form-control" name="end_time" />
        </div>
        <div class="form-group">
        	<label for="description">Comments</label>
        	<textarea class="form-control" name="description"></textarea>
        </div>
        <input type="hidden" name="pay_id" value="<?php echo $pay_id; ?>" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" name="submit" value="Add Time" class="btn btn-primary" />
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->