<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>BOS App Portal</title>
		<?php 
			echo HTML::style('css/bootstrap.css');
			echo HTML::style('css/bootstrap-theme.css');
			echo HTML::style('css/bootstrap-datetimepicker.min.css');
			echo HTML::style('css/fullcalendar.css');
			echo HTML::style('css/jquery.dataTables.css');
			echo HTML::style('css/styles.css');
		?>
		<!-- Scripts go Here -->
		<?php
			echo HTML::script('js/jquery.js');
			echo HTML::script('js/jquery-ui.js');
			echo HTML::script('js/jquery.dataTables.min.js');
			echo HTML::script('js/bootstrap.js');
			echo HTML::script('js/bootstrap-datetimepicker.js');
			echo HTML::script('js/fullcalendar.js');
			echo HTML::script('js/lotto.js');
		?>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-inverse" role="navigation" id="navigation">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="<?php echo URL::to('/'); ?>">BOS App Portal</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		      	<?php if (Auth::check()) {  ?>
		        <li><a href="<?php echo URL::to('/time/payperiods'); ?>">Time Tracking</a></li>
		        <li><a href="<?php echo URL::to('/calendar/entries'); ?>">Calendar</a></li>

		         <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Schedule<b class="caret"></b></a>
		          <ul class="dropdown-menu">

		            <li><a href="<?= URL::to('/schedule/user/my-schedule') ?>">My Schedule</a></li>
		            <li><a href="<?= URL::to('/schedule/availability/my-availability') ?>">My Availability</a></li>

		          </ul>
		        </li>
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Faculty Request <b class="caret"></b></a>
		          <ul class="dropdown-menu">
		            <li><a href="#">Action</a></li>
		            <li><a href="#">Another action</a></li>
		            <li><a href="#">Something else here</a></li>
		            <li class="divider"></li>
		            <li><a href="#">Separated link</a></li>
		            <li class="divider"></li>
		            <li><a href="#">One more separated link</a></li>
		          </ul>
		        </li>
		        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Inventory <b class="caret"></b></a>
		        	<ul class="dropdown-menu">
		        		<li><a href="<?php echo URL::to('/inventory/equipment'); ?>">View Inventory</a></li>
		        		<li><a href="<?php echo URL::to('/inventory/equipment/form'); ?>">Add Equipment</a></li>
		        	</ul>
		        </li>
		        <?php } ?>
		      </ul>
		      	<?php if(!Auth::check()) { ?>
			      <?php echo Form::open(array('url'=>'login', 'class'=>'navbar-form pull-right')); ?>
			        <div class="form-group">
			          <input type="text" name="username" class="span2" placeholder="Username">
			          <input type="password" name="password" class="span2" placeholder="Password">
			        </div>
			        <button type="submit" class="btn btn-default">Login</button>
			      </form>
			      <ul class="nav navbar-nav navbar-right">
			        <li><a data-toggle="modal" data-target="#passwordReset">Password Reset</a></li>
			      </ul>
			   	<?php } else { ?>
			   	  <ul class="nav navbar-nav navbar-right">
			   	  	<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">My Profile <b class="caret"></b></a>
			   	  		<ul class="dropdown-menu">
			   	  			<li><a href="#">Dashboard</a></li>
			   	  			<li><a href="<?php echo URL::to('/group_study'); ?>" target="_blank">Group Study</a></li>
			   	  			<li><a href="#">My Projects</a></li>
			   	  			<li><a href="<?php echo URL::to('logout'); ?>">Log Out</a></li>
			   	  		</ul>
			   	  	</li>
			   	  	<?php if (Auth::user()->admin) {   /////////////////// need to look into this - getting an error for now   //// Auth::user()->hasRole('admin') ?>
						<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo URL::to('admin/user/home'); ?>">User Management</a></li>
								<li><a href="<?php echo URL::to('admin/payroll'); ?>">Payroll</a></li>
								<li><a href="<?php echo URL::to('admin/schedule/home'); ?>">Schedule Management</a></li>
								<li><a href="#">Project Management</a></li>
								<li><a href="#">System Configurations</a></li>
							</ul>
						</li>
					<?php } ?>
			   	  </ul>
			   	<?php } ?>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		<?php if (Session::get('message')) { ?>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="alert alert-<?php echo Session::get('alert'); ?>">
						<?php echo Session::get('message'); ?>
					</div>
				</div>
			</div>
		<?php } ?>
		<div id="content">
			<?php echo $content; ?>
		</div>

		<div class="modal fade" id="passwordReset">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Password Recovery</h4>
		      </div>
		      <form role="form" method="post" action="<?php echo URL::to('passwordRecovery'); ?>">
		      	<div class="modal-body">
		        	<p>Please enter your username to recover your password</p>
		        		<div class="form-group">
		        			<label for="username">Username</label>
		        			<input type="text" class="form-control" name="username" />
		        		</div>
		      	</div>
		      	<div class="modal-footer">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        	<input class="btn btn-default" type="submit" name="submit" value="Send Recovery Email" />
		      	</div>
		      </form>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	</body>
</html>