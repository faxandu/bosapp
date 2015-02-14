<?php if(isset($status)) { ?>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
	<?php if ($status === 201) { ?>
			<div class="alert alert-success"><?php echo $message; ?></div>
	<?php } else { ?>
			<div class="alert alert-warning"><?php echo $message; ?><br /><?php echo $error; ?></div>
	<?php } ?>
		</div>
	</div>
<?php
}
?>
<div class="row">
	<div class="col-sm-4 col-sm-offset-4">
		<h2>Add Equipment</h2>
		<form method="post" action="<?php echo URL::to('/inventory/equipment/create'); ?>">
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
				<input type="text" class="form-control" name="model" />
			</div>
			<div class="form-group">
				<label for="manufacturer">Manufacturer</label>
				<input type="text" class="form-control" name="manufacturer" />
			</div>
			<div class="form-group">
				<label for="serial_number">Serial Number</label>
				<input type="text" class="form-control" name="serial_number" />
			</div>
			<div class="form-group">
				<label for="location">Location</label>
				<input type="text" class="form-control" name="location" />
			</div>
			<div class="form-group">
				<label for="obtained">Obtained Date</label>
				<input type="text" class="form-control" name="obtained" />
			</div>
			<div class="form-group">
				<label for="warranty">Warranty Expiration</label>
				<input type="text" class="form-control" name="warranty" />
			</div>
			<input type="submit" name="submit" class="btn btn-primary" value="Add Equipment" />
		</form>
	</div>
</div>
