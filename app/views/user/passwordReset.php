<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<form role="form" method="post" action="<?php echo URL::to('passwordResetSubmit'); ?>">
			<div class="form-group">
				<label for="password">New Password</label>
				<input type="password" name="password" class="form-control" />
			</div>
			<div class="form-group">
				<label for="vpassword">Verify Password</label>
				<input type="password" name="vpassword" class="form-control" />
			</div>
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<input type="submit" name="submit" value="Reset Password" />
		</form>
	</div>
</div>