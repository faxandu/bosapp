<?php if (Session::get('message')) { ?>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="alert alert-<?php echo Session::get('alert'); ?>">
		<?php echo Session::get('message'); ?>
		</div>
	</div>
</div>
<?php } ?>
<div class="row">
	<div class="col-sm-2 col-sm-offset-1">
		<form method="post" role="form" action="<?= URL::to('admin/user/create');?>">
			<h2>Create User</h2>
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" name="username" />
			</div>
			<div class="form-group">
				<label for="first_name">First Name</label>
				<input type="text" class="form-control" name="first_name" />
			</div>
			<div class="form-group">
				<label for="last_name">Last Name</label>
				<input type="text" class="form-control" name="last_name" />
			</div>
			<div class="form-group">
				<label for="email">Email Address</label>
				<input type="text" class="form-control" name="email" />
			</div>
			<input type="submit" name="submit" class="btn btn-primary" value="Add User" />
		</form>
	</div>
	<div class="col-sm-8">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Username</th>
					<th>Email Address</th>
					<th>Enabled</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($users as $user) { ?>
				<tr>
					<td><?php echo $user->first_name; ?></td>
					<td><?php echo $user->last_name; ?></td>
					<td><?php echo $user->username; ?></td>
					<td><?php echo "<a href='mailto:" . $user->email . "'>" . $user->email . "</a>"; ?></td>
					<td><a href="<?= URL::to('admin/user/disable/'.$user->id.'')?>"><b 
					class=<?php if ($user->active == '0') echo '"glyphicon glyphicon-remove delete nohover"> Enable'; else echo '"glyphicon glyphicon-ok delete nohover"> Disable'; ?> 
					</b></a></td>
					<td><a href="<?= URL::to('admin/user/delete/' . $user->id); ?>">Delete</a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
