<?php
namespace Inventory\controllers;
use BaseController, Input, User, Entry, Inventory\models\Fileadd, Inventory\models\Equipment, Response, Redirect, View, File;


class FileaddController extends BaseController{

	public function postFileup()
	{
          if (! Input::file('file')) return Redirect::back()->with('message', 'Must include a file')->with('alert', 'danger');

	  $file = new Fileadd();
	  $f = Input::file('file');

	  $name = substr($f->getClientOriginalName(), 0, strpos($f->getClientOriginalName(), '.', 1)) . '-' . time() . substr($f->getClientOriginalName(), strpos($f->getClientOriginalName(), '.', 1), 100);
	  $equip = Input::get('equipment_id');
          $notes = Input::get('notes');
          $path = '/invUploads/' . $name;
        
          $file->path = $path;
          $file->equipment_id = $equip;
          $file->notes = $notes;
	  Input::file('file')->move(public_path() . '/invUploads/', $name);
	  $file->save();
	  return Redirect::back()->with('message', 'File Uploaded')->with('alert', 'success');
	}

	//the double up on the delete functions was an attempt to let another controler delete enteries, leaving broken up for the time
	//as may look into that again later
	public function getDelete($id)
	{
	  $this->Delete($id);
	  return Redirect::back()->with('message', 'File Deleted')->with('alert', 'success');
	}

	public static function Delete($id)
	{
	  $file = FileAdd::find($id);
echo "<pre>";
print_r($file);
echo "</pre>";
	  File::delete(public_path() . $file->path);
	  $file->delete();
	}

}
?>
