<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->string('email', 255);
			$table->integer('phone');
			$table->integer('block_id');
			$table->string('password', 255);
			$table->boolean('status')->default(1);
			$table->decimal('min');
			$table->decimal('fees');
			$table->integer('restaurant_phone');
			$table->string('image', 255);
			$table->integer('whatsup');
			$table->string('api_token', 60)->nullable();
			$table->integer('pin_code')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}