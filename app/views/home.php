<?php if (Session::get('message')) { ?>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="alert alert-success">
				<?php echo Session::get('message'); ?>
			</div>
		</div>
	</div>
<?php } ?>
		<h1>hi</h1>
