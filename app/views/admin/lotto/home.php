<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<h2>User Schedule Control Panel</h2>
		<div class="row">
			<div class="col-sm-4">
				<h3>User List</h3>
				<ul class="list-group">
					<?php foreach ($users as $user) { ?>
						<li class="list-group-item"><a class="user-list" href="" data-id="<?php echo $user->id; ?>"><?php echo $user->first_name . ' ' . $user->last_name; ?></a></li>
					<?php } ?>
				</ul>
			</div>
			<div class="col-sm-4">
				<h3>User Skills</h3>
				<ul id="skill-list" class="list-group connectedSortable">
					<li class="note list-group-item"></li>

				</ul>
			</div>
			<div class="col-sm-4">
				<h3>Skill List</h3>
				<ul id="skills" class="list-group connectedSortable">
					<li class="note list-group-item"></li>
					<?php foreach ($skills as $course) { ?>
					<li class="list-group-item" data-id="<?php echo $course->id; ?>"><?php echo $course->name; ?></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<script>
var api = '<?php echo URL::to("/admin/schedule/skills"); ?>';
var user_id;

$('.user-list').on('click', function(e) {
	e.preventDefault();

	$('#skills').each(function() {
		$(this).find('li').each(function() {
			$(this).show();
		});
	});

	console.log('test');
	$('#skill-list').show();
	$('#skills').show();
	user_id = $(this).attr('data-id');
	var user = $.get(api + '/'+ $(this).attr('data-id'));
	user.success(function(res) {
		var skillList = $('#skill-list');
		skillList.empty();
		skillList.append('<li class="note list-group-item"></li>');
		for (i in res.skills) {
			$('#skills').each(function() {
				$(this).find('li').each(function() {
					if ($(this).attr('data-id') === res.skills[i].id) {
						$(this).hide();
					}
				});
			});
			skillList.append('<li class="list-group-item" data-id="' + res.skills[i].id + '">' + res.skills[i].name + '</li>');
		}

		if ($('#skill-list').height() < $('#skills').height()) {
	    	$('#skill-list').height($('#skills').height());
	    } else {
	    	$('#skills').height($('#skill-list').height());
	    }
	}).error(function(res) {
		console.log(res);
	});
});

$(function() {
	$('#skill-list').hide();
	$('#skills').hide();

	var sender;
    var recvok = false;
    $("#skills, #skill-list").sortable({
        connectWith: '.connectedSortable',
        items: ':not(.note)',
        start: function() {
            sender = $(this);
            recvok = false;
        },
        over: function() {
            recvok = ($(this).not(sender).length != 0);
        },
        stop: function(e, ui) {

            if (!recvok)

				$(this).sortable('cancel');
            	var dest = $(this).attr('id');
            	var skill = $(ui.item).attr('data-id');
            	var url;
            	switch (dest) {
            		case 'skills':
            			// Add Skill to User
            			url = "<?php echo URL::to('/admin/schedule/set-skill'); ?>";
            			break;
            		case 'skill-list':
            			// Remove Skill from User
            			url = "<?php echo URL::to('/admin/schedule/drop-skill'); ?>";
            			break;
            	}

            	var ajax = $.post(url, {user: user_id, skill: skill});
            	ajax.success(function(res) {
            		console.log(res);
            	}).error(function(res) {
            		console.log(res);
            	})
        }
    }).disableSelection();
})
</script>


<!--
My thoughts were that this page would be a control panel thing... <br>
<a href = "<?= URL::to('admin/schedule/user/all');?>">user list - what classes they are in</a><br>
<a href = "<?= URL::to('admin/schedule/user/set-skills');?>">user skill form</a><br>
<a href = "<?= URL::to('admin/schedule/course/all');?>">course list</a><br>
-->

