<?php
namespace Inventory\controllers;
use BaseController, Input, User, Entry, Inventory\models\Fileadd, Inventory\models\Equipment, Response, Redirect, View, Excel;


class FileaddController extends BaseController{

	public function postFileup()
	{
echo "<pre>";
	print_r( Input::file('file'));
echo "</pre>";

$f = new Fileadd();
$equip = Equipment::find(50);

	$file = Input::file('file');
//	$name = $file->getClientOriginalName();
	$name = 'testfile';
//	Input::file('file')->move(public_path(), $name);
	exit;
	}


}
?>
