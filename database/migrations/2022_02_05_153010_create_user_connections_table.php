<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_connections', function (Blueprint $table) {
            $table->id();

			$table->unsignedBigInteger('user_id_a');
			$table->foreign('user_id_a')
				->references('id')->on('users')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->unsignedBigInteger('user_id_b');
			$table->foreign('user_id_b')
				->references('id')->on('users')
				->onDelete('no action')
				->onUpdate('no action');

			$table->unsignedBigInteger('user_connection_status_id');
			$table->foreign('user_connection_status_id')
				->references('id')->on('user_connection_status')
				->onDelete('no action')
				->onUpdate('no action');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_connections');
    }
}
