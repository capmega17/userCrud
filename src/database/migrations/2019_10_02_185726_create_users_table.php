<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('remember_token', 191)->nullable();
			$table->string('status', 191)->nullable();
			$table->string('name', 191);
			$table->string('seoname', 191);
			$table->string('email', 191)->unique();
			$table->string('password', 191);
			$table->string('avatar', 191);
			$table->integer('center_id')->unsigned()->index('users_center_id_foreign');
			$table->integer('role_id')->unsigned()->index('users_role_id_foreign');
			$table->string('sign', 191)->nullable();
			$table->string('email_sign', 191)->nullable();
			$table->integer('client_id')->unsigned()->nullable();
			$table->boolean('can_quote')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
