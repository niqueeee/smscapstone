<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShiftsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shifts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('fshift_user_id_idx');
			$table->integer('school_id')->unsigned()->index('fshift_school_id_idx');
			$table->integer('course_id')->unsigned()->index('fshift_course_id_idx');
			$table->string('subject_deficiency', 25);
			$table->integer('class_card')->unsigned();
			$table->date('shift_date');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shifts');
	}

}
