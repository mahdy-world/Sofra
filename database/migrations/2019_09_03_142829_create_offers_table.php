<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('image', 255);
			$table->string('name', 255);
			$table->text('description');
			$table->date('from');
			$table->date('to');
			$table->integer('restaurant_id');
			$table->decimal('offer_pirce');
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}