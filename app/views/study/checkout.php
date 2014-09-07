<style>
#navigation {display: none !important;}
</style>
<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<h2>Signed Out</h2>
		<p>You have signed out. Thank you for attending the Group Study Session!</p>
	</div>	
</div>

<script>
$(function() {
	setTimeout(function() {
		window.location.replace("<?php echo URL::to('/group_study'); ?>");
	}, 5000);

});

</script>