<style>
#navigation {display: none !important;}
</style>
<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<h3>Group Study Sign In</h3>
		<p>Welcome to the new Group Study sign in application. </p>
		<form method="post" action="<?php echo URL::to('/group_study/entry/student-exists'); ?>" id="swipe">
			<div class="form-group">
				<label>Select the class you are attending group study for</label>
				<br />
				<h5>Programming</h5>
				<label for="CPS120" class="btn btn-primary">
					<input type="radio" id="CPS120" name="class" value="CPS120" />
					CPS 120
				</label>
				<label for="CPS161" class="btn btn-primary">
					<input type="radio" id="CPS161" name="class" value="CPS161" />
					CPS 161
				</label>
				<label for="CPS171" class="btn btn-primary">
					<input type="radio" id="CPS171" name="class" value="CPS171" />
					CPS 171
				</label>
				<label for="CPS261" class="btn btn-primary">
					<input type="radio" id="CPS261" name="class" value="CPS261" />
					CPS 261
				</label>
				<label for="CPS271" class="btn btn-primary">
					<input type="radio" id="CPS271" name="class" value="CPS271" />
					CPS 271
				</label>
				<label for="CPS272" class="btn btn-primary">
					<input type="radio" id="CPS272" name="class" value="CPS272" />
					CPS 272
				</label>
				<label for="CPS276" class="btn btn-primary">
					<input type="radio" id="CPS276" name="class" value="CPS276" />
					CPS 276
				</label>
				<label for="CPS278" class="btn btn-primary">
					<input type="radio" id="CPS278" name="class" value="CPS278" />
					CPS 278
				</label>
				<h5>Windows Networking</h5>
				<label for="CNT100" class="btn btn-primary">
					<input type="radio" id="CNT100" name="class" value="CNT100" />
					CNT 100
				</label>
				<label for="CNT201" class="btn btn-primary">
					<input type="radio" id="CNT201" name="class" value="CNT201" />
					CNT 201
				</label>
				<label for="CNT206" class="btn btn-primary">
					<input type="radio" id="CNT206" name="class" value="CNT206" />
					CNT 206
				</label>
				<label for="CNT211" class="btn btn-primary">
					<input type="radio" id="CNT211" name="class" value="CNT211" />
					CNT 211
				</label>
				<label for="CNT216" class="btn btn-primary">
					<input type="radio" id="CNT216" name="class" value="CNT216" />
					CNT 216
				</label>
				<label for="CNT223" class="btn btn-primary">
					<input type="radio" id="CNT223" name="class" value="CNT223" />
					CNT 223
				</label>
				<label for="CNT224" class="btn btn-primary">
					<input type="radio" id="CNT224" name="class" value="CNT224" />
					CNT 224
				</label>
				<label for="CNT226" class="btn btn-primary">
					<input type="radio" id="CNT226" name="class" value="CNT226" />
					CNT 226
				</label>
				<label for="CNT236" class="btn btn-primary">
					<input type="radio" id="CNT236" name="class" value="CNT236" />
					CNT 236
				</label>

				<h5>Computer Systems Technology</h5>
				<label for="CST118" class="btn btn-primary">
					<input type="radio" id="CST118" name="class" value="CST118" />
					CST 118
				</label>
				<label for="CST160" class="btn btn-primary">
					<input type="radio" id="CST160" name="class" value="CST160" />
					CST 160
				</label>
				<label for="CST165" class="btn btn-primary">
					<input type="radio" id="CST165" name="class" value="CST165" />
					CST 165
				</label>
				<label for="CST225" class="btn btn-primary">
					<input type="radio" id="CST225" name="class" value="CST225" />
					CST 225
				</label>

				<h5>Unix / Linux</h5>
				<label for="CIS121" class="btn btn-primary">
					<input type="radio" id="CIS121" name="class" value="CIS121" />
					CIS 121
				</label>
				<label for="CIS161" class="btn btn-primary">
					<input type="radio" id="CIS161" name="class" value="CIS161" />
					CIS 161
				</label>
				<label for="CIS208" class="btn btn-primary">
					<input type="radio" id="CIS208" name="class" value="CIS208" />
					CIS 208
				</label>
				<label for="CIS206" class="btn btn-primary">
					<input type="radio" id="CIS206" name="class" value="CIS206" />
					CIS 206
				</label>
				<label for="CIS221" class="btn btn-primary">
					<input type="radio" id="CIS221" name="class" value="CIS221" />
					CIS 221
				</label>

				<h5>Accounting</h5>
				<label for="ACC110" class="btn btn-primary">
					<input type="radio" id="ACC110" name="class" value="ACC110" />
					ACC 110
				</label>
				<label for="ACC111" class="btn btn-primary">
					<input type="radio" id="ACC111" name="class" value="ACC111" />
					ACC 111
				</label>
				<label for="ACC122" class="btn btn-primary">
					<input type="radio" id="ACC122" name="class" value="ACC122" />
					ACC 122
				</label>
				
			</div>
			<div class="form-group">
				<label for="student_num">Swipe your Student ID</label>
				<input name="student_num" type="text" class="form-control" id="student_id" autofocus/>
			</div>
		</form>
	</div>
</div>
</br></br>
<div class="row">
	<div class="col-sm-8 col-sm-offset-3">
		<button class="btn btn-success" data-toggle="modal" data-target="#groupStudyEntry">Manually Add Entry</button>
	</div>
</div>


<div class="modal fade" id="groupStudyEntry">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Group Study Entry</h4>
      </div>
      <form role="form" method="post" action="<?php echo URL::to('group_study/entry/manual-create'); ?>" >
      <div class="modal-body">
        <div class="form-group">
        	<label for="start_date">Student Number</label>
        	<input type="test" id="student_num" class="form-control" name="student_num" />
        </div>
        <div class="form-group"><p>Student number should be entered like 0055555</p>
        	<label for="start_time">Class</label>
        	<input type="test" id="class" class="form-control" name="class" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" name="submit" value="Add Entry" class="btn btn-primary" />
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
var timer;

$('#student_id').keyup(function(e) {
	timer = setTimeout(function() {
		$('#swipe').submit();
	}, 300);
});

$('#student_id').keydown(function(e) {
	clearTimeout(timer);
});

$(':radio').on('click', function() {
	$('#student_id').focus();
});


</script>
