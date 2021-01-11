<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends model {

	protected $table = 'notifications';
	public $timestamps = true;
	protected $fillable = array('title', 'body', 'notifiable_id', 'notifiable_type');

	public function order()
	{
		return $this->belongsTo('App\Models\Order');
	}

	public function notifiable()
	{
		return $this->morphTo();
	}

}
