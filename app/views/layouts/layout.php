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
			echo HTML::style('css/styles.css');
		?>
		<!-- Scripts go Here -->
	<?php
		echo HTML::script('js/jquery.js');
		echo HTML::script('js/jquery-ui.js');
		echo HTML::script('js/bootstrap.js');
		echo HTML::script('js/bootstrap-datetimepicker.js');
		echo HTML::script('js/fullcalendar.js');
	?>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-inverse" role="navigation">
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
		        <li><a href="#">Time Tracking</a></li>
		        <li><a href="<?php echo URL::to('/calendar/entries'); ?>">Calendar</a></li>
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
		      </ul>
		      	<?php if(!Auth::check()) { ?>
			      <?php echo Form::open(array('url'=>'users/login', 'class'=>'navbar-form pull-right')); ?>
			        <div class="form-group">
			          <input type="text" name="username" class="span2" placeholder="Username">
			          <input type="password" name="password" class="span2" placeholder="Password">
			        </div>
			        <button type="submit" class="btn btn-default">Login</button>
			      </form>
			      <ul class="nav navbar-nav navbar-right">
			        <!-- <li><a href="<?php echo URL::to('users/register'); ?>">Register</a></li> -->
			      </ul>
			   	<?php } else { ?>
			   	  <ul class="nav navbar-nav navbar-right">
			   	  	<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">My Profile <b class="caret"></b></a>
			   	  		<ul class="dropdown-menu">
			   	  			<li><a href="#">Dashboard</a></li>
			   	  			<li><a href="#">My Projects</a></li>
			   	  			<li><a href="<?php echo URL::to('users/logout'); ?>">Log Out</a></li>
			   	  		</ul>
			   	  	</li>
			   	  	<?php if (Auth::user()->hasRole('admin')) { ?>
						<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo URL::to('admin/useradmin'); ?>">User Management</a></li>
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
		<div id="content">
			<?php echo $content; ?>
		</div>

	

	</body>
</html>