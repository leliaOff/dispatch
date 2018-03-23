<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendsStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sends_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('send_id');
            $table->foreign('send_id')->references('id')->on('sends');
            $table->enum('status', ['created', 'send', 'received', 'read', 'send_failed', 'receive_failed']);
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
        Schema::dropIfExists('sends_statuses');
    }
}
