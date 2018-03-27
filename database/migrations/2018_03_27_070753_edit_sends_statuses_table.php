<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditSendsStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sends_statuses', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->integer('status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sends_statuses', function (Blueprint $table) {
            $table->dropColumn('status_id');
            $table->enum('status', ['created', 'send', 'received', 'read', 'send_failed', 'receive_failed']);
        });
    }
}
