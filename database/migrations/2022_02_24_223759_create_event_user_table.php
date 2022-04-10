<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_user', function (Blueprint $table) {
			$table->id();
			$table->boolean('confirmed')->default(false);
			$table->unsignedBigInteger('event_id');
			$table->foreign('event_id')
				->references('id')->on('events')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->unsignedBigInteger('event_group_id');
			$table->foreign('event_group_id')
				->references('group_id')->on('events')
				->onDelete('cascade')
				->onUpdate('cascade');

			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade')
				->onUpdate('cascade');

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
        Schema::dropIfExists('event_user');
    }
};
