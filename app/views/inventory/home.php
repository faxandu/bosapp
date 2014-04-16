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
										</tr>
									</thead>
									<tbody>
										<?php $item->contract->each(function($contract) { ?>
										<tr>
											<td><?php echo $contract['type']; ?></td>
											<td><?php echo $contract['expiration']; ?></td>
											<td><?php echo $contract['contract_number']; ?></td>
											<td><?php echo $contract['vendor']; ?></td>
										</tr>
										<?php }); ?>
									</tbody>
								</table>
								<div class="button">
									<button class="btn btn-xs btn-primary addContracts" data-id="<?php echo $item['id']; ?>">Add Service Contracts</button>
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
<div class="modal fade" id="componentsForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form method="post" action="<?php echo URL::to('/inventory/components/create'); ?>">
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
    	<form method="post" action="<?php echo URL::to('/inventory/contracts/create'); ?>">
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