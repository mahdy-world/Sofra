<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->string('email', 255);
			$table->integer('phone');
			$table->text('message');
			$table->enum('type', array('complain', 'suggest', 'enquiry'));
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}