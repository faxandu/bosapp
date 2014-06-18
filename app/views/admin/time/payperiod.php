<div class="row">
	<div class="col-sm-6 col-sm-offset-4">
		<button class="btn btn-success" data-toggle="modal" data-target="#addPayPeriod">Add Pay Period</button>
	</div>
</div>
<div class="row">
  <div class="col-sm-3 col-sm-offset-1">
    <form role="form" method="post" action="<?php echo URL::to('admin/time/categories/create'); ?>">
        <div class="form-group">
          <label for="category">Category Name</label>
          <input type="text" name="category" class="form-control" />
        </div>
        <input type="submit" name="submit" class="btn btn-primary" value="Add Category" />
    </form>
  </div>
	<div class="col-sm-6">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Start Date</th>
					<th>End Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($pay_periods as $period) { ?>
				<tr>
					<td><a href="#" style="display:block;"><?php echo $period->start_pay_period; ?></a></td>
					<td><a href="#" style="display:block;"><?php echo $period->end_pay_period; ?></a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="addPayPeriod">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Pay Period</h4>
      </div>
      <form role="form" method="post" action="<?php echo URL::to('admin/time/createPayPeriod'); ?>">
      	<div class="modal-body">
        	<div class="form-group">
        		<label for="name">Pay Period Name</label>
        		<input type="text" name="name" class="form-control" />
        	</div>
        	<div class="form-group">
        		<label for="start_pay_period">Start Date</label>
        		<input type="date" name="start_pay_period" class="form-control" />
        	</div>
        	<div class="form-group">
        		<label for="end_pay_period">End Date</label>
        		<input type="date" name="end_pay_period" class="form-control" />
        	</div>


      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	<input type="submit" name="submit" class="btn btn-default" value="Add Pay Period" />
      	</div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
