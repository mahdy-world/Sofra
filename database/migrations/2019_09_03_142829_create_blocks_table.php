<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlocksTable extends Migration {

	public function up()
	{
		Schema::create('blocks', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->integer('city_id');
		});
	}

	public function down()
	{
		Schema::drop('blocks');
	}
}