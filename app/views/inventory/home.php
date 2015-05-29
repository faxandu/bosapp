<?php if(null !== Session::get('status')) { ?>

	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
	<?php if (Session::get('status') === 201) { ?>
			<div class="alert alert-success"><?php echo Session::get('message'); ?></div>
	<?php } else { ?>
			<div class="alert alert-warning"><?php echo Session::get('message'); ?><br /><?php echo Session::get('error'); ?></div>
	<?php } ?>
		</div>
	</div>
<?php
}
?>
<table align='center'>
	<tr>
		<td><a href='<?php echo URL::to('/inventory/equipment/report'); ?>' class='btn btn-success'>Full Report</a></td>
		<td><a href='<?php echo URL::to('/inventory/equipment/report-contract'); ?>' class='btn btn-success'>Report Contracts</a></td>
	</tr>
</table>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<table id="inventory" class="table inventory">
			<thead>
				<tr>
					<th>Equipment</th>
					<th>Details</th>
				</tr>
			</thead>
			<tbody>
				<?php $equipment->each(function($item) { ?>
					<tr>
						<td class="equipment">
							<div class="type"><?php echo $item['type']; ?> </div>
							<p>Manufacturer: <?php echo $item['manufacturer']; ?></p>
							<p>Model Number: <?php echo $item['model']; ?></p>
							<p>Serial Number: <?php echo $item['serial_number']; ?></p>
							<p>Obtained On: <?php echo $item['obtained']; ?></p>
							<p>Warrant Expires On: <?php echo $item['warranty']; ?></p>
							<p>Location: <?php echo $item['location']; ?></p>
							<p><a href="/inventory/equipment/delete/<?php echo $item['id']?>" class='btn btn-danger'>Delete</a><button class="btn btn-warning" data-toggle="modal" data-target="#ModifyForm" onclick='setId(<?php echo $item['id'] . ', "' . $item['manufacturer'] . '", "' . $item['model'] . '", "' . $item['serial_number'] . '", "' . $item['obtained'] . '", "' . $item['warranty'] . '", "' . $item['location'] . '"'; ?>)'>Modify</button></p>
						</td>
						<td class="details">
							<div class="components">
								<h4>Components</h4>
								<table class="table">
									<thead>
										<tr>
											<th>Type</th>
											<th>Model Number</th>
											<th>Location</th>
											<th>Storage</th>
											<th>Memory</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									<?php $item->component->each(function($component) { ?>
										<tr>
											<td><?php echo $component['type']; ?></td>
											<td><?php echo $component['model']; ?></td>
											<td><?php echo $component['location']; ?></td>
											<td><?php echo $component['storage']; ?></td>
											<td><?php echo $component['memory']; ?></td>
											<td><a href="/inventory/component/delete/ <?php echo $component['id']; ?>" class="btn btn-danger">Delete Component</a></td>
										</tr>
									<?php }); ?>
									</tbody>
								</table>

								<div class="button">
									<button class="btn btn-xs btn-primary addComponents" data-id="<?php echo $item['id']; ?>">Add Components</button>
								</div>
							</div>
							<div class="contracts">
								<h4>Service Contracts</h4>
								<table class="table">
									<thead>
										<tr>
											<th>Type</th>
											<th>Expiration Date</th>
											<th>Contract Number</th>
											<th>Vendor</th>
											<th>Contract Info</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php $item->contract->each(function($contract) { ?>
										<tr>
											<td><?php echo $contract['type']; ?></td>
											<td><?php echo $contract['expiration']; ?></td>
											<td><?php echo $contract['contract_number']; ?></td>
											<td><?php echo $contract['vendor']; ?></td>
											<td><?php echo $contract['contact_info']; ?></td>
											<td rowspan="2"><a href="/inventory/contract/delete/<?php echo $contract['id'];?>" class="btn btn-danger">Delete Contract</a></td>
										</tr>
										<tr>
											<th>Contract Notes</th>
											<td colspan="4"><?php echo $contract['notes']; ?></td>
										</tr>
										<?php }); ?>
									</tbody>
								</table>
								<div class="button">
									<button class="btn btn-xs btn-primary addContracts" data-id="<?php echo $item['id']; ?>">Add Service Contracts</button>
								</div>
<?php //--------------------------------------------work on file fields here------------------------------------------- ?>

							<div class="contracts">
								<h4>Attached Files</h4>
								<table class="table">
									<tbody>
										<?php $item->contract->each(function($contract) { ?>
										<tr>
											<td><?php echo "filename/download"; ?></td>
											<td><?php echo "notes"; ?></td>
											<td rowspan="2"><a href="/inventory/fileadd/delete/<?php echo $contract['id'];?>" class="btn btn-danger">Delete File</a></td>
										</tr>
										<?php }); ?>
									</tbody>
								</table>
								<div class="button">
									<?php echo Form::open(array('url' => 'inventory/fileadd/fileup', 'files' => true, 'method' => 'post')) ?>
									<?php echo Form::file('file'); ?>
									<input type='submit' value='Add File' />
									</form>
								</div>



							</div>
						</td>
					</tr>
				<?php }); ?>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModifyForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form method="post" action="<?php echo URL::to('/inventory/equipment/update'); ?>">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id="myModalLabel">Add Component</h4>
      		</div>
		<div class="modal-body">
                        <div class="form-group">
                                <label for="type">Equipment Type</label>
                                <select name="type" class="form-control">
                                        <option value="computer">Computer</option>
                                        <option value="router">Router</option>
                                        <option value="firewall">Firewall</option>
                                        <option value="switch">Switch</option>
                                        <option value="server">Server</option>
                                </select>
                        </div>
			<div class="form-group">
                                <label for="model">Model Number</label>
                                <input type="text" id="modify_model" class="form-control" name="model" />
                        </div>
                        <div class="form-group">
                                <label for="manufacturer">Manufacturer</label>
                                <input type="text" id="modify_manufacturer" class="form-control" name="manufacturer" />
                        </div>
                        <div class="form-group">
                                <label for="serial_number">Serial Number</label>
                                <input type="text" id="modify_serial_number" class="form-control" name="serial_number" />
                        </div>
                        <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" id="modify_location" class="form-control" name="location" />
                        </div>
                        <div class="form-group">
                                <label for="obtained">Obtained Date</label>
                                <input type="text" id="modify_obtained" class="form-control" name="obtained" />
                        </div>
                        <div class="form-group">
                                <label for="warranty">Warranty Expiration</label>
				<input type="text" id="modify_warranty" class="form-control" name="warranty" />
                        </div>
		</div>
     		<div class="modal-footer">
			<input type="hidden" id="modify_id" value ="" name="id"/>
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		<input type="submit" class="btn btn-primary" name="submit" value="Modify Equipment" />
      		</div>
      	</form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="componentsForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form method="post" action="<?php echo URL::to('/inventory/component/create'); ?>">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id="myModalLabel">Add Component</h4>
      		</div>
      		<div class="modal-body">
        		<div class="form-group">
        			<label for="type">Type</label>
        			<input type="text" class="form-control" name="type" />
        		</div>
        		<div class="form-group">
        			<label for="model">Model Number</label>
        			<input type="text" class="form-control" name="model" />
        		</div>
        		<div class="form-group">
        			<label for="location">Location</label>
        			<input type="text" class="form-control" name="location" />
        		</div>
        		<div class="form-group">
        			<label for="storage">Storage</label>
        			<input type="text" class="form-control" name="storage" />
        		</div>
        		<div class="form-group">
        			<label for="memory">Memory</label>
        			<input type="text" class="form-control" name="memory" />
        		</div>
      		</div>
      		<div class="modal-footer">
      			<input type="hidden" name="equipment_id" />
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		<input type="submit" class="btn btn-primary" name="submit" value="Add Component" />
      		</div>
      	</form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="contractForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form method="post" action="<?php echo URL::to('/inventory/contract/create'); ?>">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h4 class="modal-title" id="myModalLabel">Add Service Contract</h4>
      		</div>
      		<div class="modal-body">
        		<div class="form-group">
        			<label for="type">Type</label>
        			<input type="text" class="form-control" name="type" />
        		</div>
        		<div class="form-group">
        			<label for="expiration">Expiration Date</label>
				YYYY-MM-DD
        			<input type="text" class="form-control" name="expiration" />
        		</div>
        		<div class="form-group">
        			<label for="contract_number">Contract Number</label>
        			<input type="text" class="form-control" name="contract_number" />
          		</div>
        		<div class="form-group">
        			<label for="vendor">Vendor</label>
        			<input type="text" class="form-control" name="vendor" />
        		</div>
        		<div class="form-group">
        			<label for="contact_info">Contact Information</label>
        			<input type="text" class="form-control" name="contact_info" />
        		</div>
        		<div class="form-group">
        			<label for="notes">Additional Notes</label>&nbsp&nbsp&nbsp&nbsp&nbspLimit 255 Characters
        			<input type="text" class="form-control" name="notes" />
        		</div>
      		</div>
      		<div class="modal-footer">
      			<input type="hidden" name="equipment_id" />
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		<input type="submit" class="btn btn-primary" name="submit" value="Add Service Contract" />
      		</div>
      	</form>
    </div>
  </div>
</div>

<script>

function setId(id, manufacturer, model, serial_number, obtained, warrenty, location)
{
  document.getElementById("modify_id").value = id;
  document.getElementById("modify_manufacturer").value = manufacturer;
  document.getElementById("modify_model").value = model;
  document.getElementById("modify_serial_number").value = serial_number;
  document.getElementById("modify_obtained").value = obtained;
  document.getElementById("modify_warranty").value = warrenty;
  document.getElementById("modify_location").value = location;
}


$(document).ready(function() {
    $('#inventory').dataTable();
} );

$('.addComponents').on('click', function() {
	$('#componentsForm').find('input[name="equipment_id"]').val($(this).attr('data-id'));
	$('#componentsForm').modal('show');
});

$('.addContracts').on('click', function() {
	$('#contractForm').find('input[name="equipment_id"]').val($(this).attr('data-id'));
	$('#contractForm').modal('show');
});

</script>
