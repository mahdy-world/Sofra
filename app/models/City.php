<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class City extends model {

	protected $table = 'cities';
	public $timestamps = true;
	protected $fillable = array('name');

	public function blocks()
	{
		return $this->hasMany('App\Models\Block');
	}

}
