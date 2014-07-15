<style>
#navigation {display: none !important;}
</style>
<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<h2>Signed In</h2>
		<p>You have signed in as <?php echo $student->first_name . ' ' . $student->last_name; ?>. Please remember to sign out when you leave!</p>
	</div>	
</div>

<script>
$(function() {
	setTimeout(function() {
		window.location.replace("<?php echo URL::to('/group_study'); ?>");
	}, 10000);

});

</script>