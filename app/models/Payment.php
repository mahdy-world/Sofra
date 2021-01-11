<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends model {

	protected $table = 'payments';
	public $timestamps = true;
	protected $fillable = array('note', 'amount','restaurant_id');

	public function restaurant()
	{
		return $this->belongsTo('App\Models\Restaurant');
	}

}
