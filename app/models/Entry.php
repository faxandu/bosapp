<?php 

class Entry extends Eloquent {

	protected $table = 'global_entry';
	public $timestamps = true;


    
	protected $fillable = array('title', 'description', 'start_time', 'end_time', 'start_date', 'end_date',
        'clocked_in');


	protected $guarded = array('id');
    protected $hidden = array('pivot');



	public static function boot(){
        parent::boot();

        

    }

	// public function labAides(){
 //        return $this->belongsToMany('User', 'lotto_course_labAide');
 //    }

   
}

