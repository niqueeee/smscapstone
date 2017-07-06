<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserAllocationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_allocation', function(Blueprint $table)
		{
			$table->foreign('allocation_id', 'fuserallocationallocationid')->references('id')->on('allocations')->onUpdate('CASCADE')->onDelete('RESTRICT');
			$table->foreign('user_id', 'fuserallocationuserid')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_allocation', function(Blueprint $table)
		{
			$table->dropForeign('fuserallocationallocationid');
			$table->dropForeign('fuserallocationuserid');
		});
	}

}