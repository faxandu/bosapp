create user form<br><br>

Validation not yet set<br><br>
<?= (Session::get('error') ? print_r(Session::get('error')) : 'no errors') ?><br><br>


<form method ="POST" action="<?= URL::to('admin/user/create');?>">

username<input type="text" name="username"><br>
password<input type="password" name="password"><br>
<input type="submit">


</form>

