<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends model {

	protected $table = 'offers';
	public $timestamps = true;
	protected $fillable = array('image', 'name', 'description', 'from', 'to', 'offer_price','restaurant_id');

	public function restaurant()
	{
		return $this->belongsTo('App\Models\Restaurant');
	}

}
