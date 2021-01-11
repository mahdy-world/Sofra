<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends model {

	protected $table = 'reviews';
	public $timestamps = true;
	protected $fillable = array('react', 'comment','client_id','restaurant_id');

	public function client()
	{
		return $this->belongsTo('App\Models\Client');
	}

	public function restaurant()
	{
		return $this->belongsTo('App\Models\Restaurant');
	}

}
