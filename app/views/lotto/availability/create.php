
<h2>to do</h2>
<p>What time format? </p>
<br><br>
<?= (Session::get('error') ? print_r(Session::get('error')) : 'no errors') ?><br><br>

<form method='POST' action='<?= URL::to('/schedule/availability/create'); ?>'>


end_date: <input text="text" name="end_date"><br>
start_date: <input text="text" name="start_date"><br>
end_time: <input text="text" name="end_time"><br>
start_time: <input text="text" name="start_time"><br>
notes: <input text="text" name="notes"><br>
title: <input text="text" name="title"><br>

<input type="submit" value="click">
</form>
