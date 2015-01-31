<?php //print_r($ent);
/*
*********jason comments
*this is the front end view file for modifying group study entries
*
*most of this code is copied pasted from craigs stuff that was left behind.
*the var $ent (short for enteries) has the fields:
* FILL IN LATER ONCE ID IS WORKING
*
*/ ?>

<div class="row">
        <div class="col-sm-6 col-sm-offset-3">
                <table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Class</th>
					<th>Date</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Student</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($ent as $i) { ?>
				<tr>
					<td><?php echo $i->class; ?></td>
					<td><?php echo $i->date; ?></td>
					<td><?php echo $i->start_time; ?></td>
					<td><?php echo $i->end_time; ?></td>
					<td><?php echo $i->student_name->first_name . ' ' . $i->student_name->last_name; ?></td>
					<td><button class="btn btn-warning" data-toggle="modal" data-target="#entryModify" onclick='setId(<?= $i->id . ', "' . $i->class . '", "' . $i->date . '", "' . $i->start_time . '", "' . $i->end_time . '"'; ?>)'>Modify</button>
					    <a href="<?php echo URL::to('/group_study/entry/delete-entry/' . $i->id); ?>" class="btn btn-danger">Delete</a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="entryModify">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modify Student Entry</h4>
      </div>
      <form role="form" method="post" action="<?php echo URL::to('/group_study/entry/delete-entry/' . $i->id); ?>" >
        <input type="hidden" id="id" name="id" value="" />
      <div class="modal-body">
        <div class="form-group">
        	<label for="class">Class</label>
        	<input type="test" id="class" class="form-control" name="class" value="default" />
        </div>
        <div class="form-group">
        	<label for="date">Date</label>
        	<input type="test" id="date" class="form-control" name="date" />
        </div>
        <div class="form-group">
        	<label for="start_time">Start Time</label>
        	<input type="test" id="start_time" class="form-control" name="start_time" />
        </div>
        <div class="form-group">
        	<label for="end_time">End Time</label>
        	<input type="test" id="end_time" class="form-control" name="end_time" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" name="submit" value="Modify" class="btn btn-primary" />
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
function setId(id, Gclass, date, startTime, endTime)
{
  document.getElementById("id").value = id;
  document.getElementById("class").value = Gclass;
  document.getElementById("date").value = date;
  document.getElementById("start_time").value = startTime;
  document.getElementById("end_time").value = endTime;
}

$(function() {
  $('#date').datetimepicker({
    timepicker: false,
    format: 'Y-m-d',
    todayButton: true,
  });
  $('#start_time').datetimepicker({
    datepicker: false,
    step: 5,
    format: 'H:i',
  });
 $('#end_time').datetimepicker({
    datepicker: false,
    step: 5,
    format: 'H:i',
  });
})
</script>
