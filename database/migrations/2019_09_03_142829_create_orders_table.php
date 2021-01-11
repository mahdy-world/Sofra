<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('restaurant_id');
			$table->integer('client_id');
			$table->enum('status', array('accpeted', 'rejected', 'accepted', 'pending', 'delivered', 'declined'));
			$table->decimal('price');
			$table->decimal('delivery_cost');
			$table->decimal('comission');
			$table->decimal('total');
			$table->string('note', 255);
			$table->string('address', 255);
			$table->integer('payment_method_id');
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}