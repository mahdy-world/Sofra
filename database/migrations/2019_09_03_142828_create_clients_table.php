<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->string('email', 255);
			$table->integer('phone');
			$table->string('password', 255);
			$table->integer('block_id');
			$table->string('api_token', 60)->nullable();
			$table->integer('pin_code')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}