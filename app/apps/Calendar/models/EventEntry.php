<?php
/**
 * User: Kayla
 * Date: 4/5/14
 * Time: 12:57 PM
 */

namespace Calendar\models;
use Eloquent, Validaton, Exception;
use Illuminate\Support\Facades\Auth;

class EventEntry extends Eloquent{

    protected $table = 'events';
    protected $fillable = array('title','start_date'
                             ,'end_date','description',
                             'created_by', 'created_for','last_updated_by');
    protected $guarded = 'id';
    public $timestamps = false;

    public function entry(){
        return $this->belongsTo('user');
    }

    public function scopeUser($query) {
    	return $query->where('user_id', \Auth::user()->id);
    }

    public function scopePeriod($query, $pay_id) {
    	return $query->where('pay_id', $pay_id);
    }

} 

/*

CREATE TABLE events(
	id int(6) unsigned AUTO_INCREMENT PRIMARY KEY,
	title varchar(40) NOT NULL,
	start_date datetime NOT NULL,
	end_date datetime NOT NULL,
	description tinytext,
	last_updated_by varchar(40) NOT NULL,
	created_by varchar(40) NOT NULL,
	created_for varchar(40) NOT NULL
);
*/