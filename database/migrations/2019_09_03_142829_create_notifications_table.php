<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 255);
			$table->string('body', 255);
			$table->integer('order_id');
			$table->enum('action', array('accepted', 'rejected', 'delivered', 'new'));
			$table->integer('notifiable_id');
			$table->string('notifiable_type', 255);
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}