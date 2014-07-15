<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<form method="post" action="<?php echo URL::to('/group_study/entry/swipe'); ?>" id="swipe">
			<div class="form-group">
				<label for="class1" class="btn btn-primary">
					<input type="radio" id="class1" name="class" value="class1" />
					Class 1
				</label>
				<label for="class2" class="btn btn-primary">
					<input type="radio" id="class2" name="class" value="class2" />
					Class 2
				</label>
				<label for="class3" class="btn btn-primary">
					<input type="radio" id="class3" name="class" value="class3" />
					Class 3
				</label>
				<label for="class4" class="btn btn-primary">
					<input type="radio" id="class4" name="class" value="class4" />
					Class 4
				</label>
				<label for="class5" class="btn btn-primary">
					<input type="radio" id="class5" name="class" value="class5" />
					Class 5
				</label>
			</div>
			<div class="form-group">
				<label for="student_num">Swipe your Student ID</label>
				<input name="student_num" type="text" class="form-control" id="student_id" autofocus/>
			</div>
		</form>
	</div>
</div>

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

</script>