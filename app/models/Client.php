<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable {

	protected $table = 'clients';
	public $timestamps = true;
	protected $fillable = array('name', 'email', 'phone', 'password','block_id','api_token','pin_code');

	public function orders()
	{
		return $this->hasMany('App\Models\Order');
	}

	public function reviews()
	{
		return $this->hasMany('App\Models\Review');
	}

	public function block()
	{
		return $this->belongsTo('App\Models\Block');
	}

	public function notifications()
	{
		return $this->morphMany('App\Models\Notification', 'notifiable');
	}

	public function tokens()
	{
		return $this->morphMany('App\Models\Token', 'tokenable');
	}

    protected $hidden = [
        'password', 'api_token',
    ];


}
