<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditChannelsTableAddContactsTypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channels', function (Blueprint $table) {
            $table->unsignedInteger('contacts_type_id')->default(1);
            $table->foreign('contacts_type_id')->references('id')->on('contacts_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channels', function (Blueprint $table) {
            $table->dropForeign('contacts_types_id_foreign');
            $table->dropColumn('contacts_type_id');
        });
    }
}
