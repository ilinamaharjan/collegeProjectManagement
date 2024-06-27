<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToLeadSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_settings', function (Blueprint $table) {
            $table->dropColumn('unique_name');
            $table->unsignedBigInteger('status_setting_id');
            $table->id();
            $table->string('notifier')->nullable();
            $table->string('favcolor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_settings', function (Blueprint $table) {
            //
        });
    }
}
