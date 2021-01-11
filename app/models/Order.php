<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends model {

	protected $table = 'orders';
	public $timestamps = true;
	protected $fillable = array('price', 'delivery_cost', 'commission', 'total','status', 'note', 'address','restaurant_id','payment_method_id');

	public function items()
	{
		return $this->belongsToMany('App\Models\Item')->withPivot('price','qty','note');
	}

	public function notifications()
	{
		return $this->hasMany('App\Models\Notification');
	}

	public function client()
	{
		return $this->belongsTo('App\Models\Client');
	}

	public function restaurant()
	{
		return $this->belongsTo('App\Models\Restaurant');
	}

	public function paymentMethod()
	{
		return $this->belongsTo('App\Models\PaymentMethod');
	}

}
