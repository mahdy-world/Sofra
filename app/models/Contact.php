<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends model {

	protected $table = 'contacts';
	public $timestamps = true;
	protected $fillable = array('name', 'email', 'phone', 'message','type');

}
