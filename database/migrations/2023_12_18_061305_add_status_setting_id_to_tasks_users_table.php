<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusSettingIdToTasksUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks_users', function (Blueprint $table) {
            $table->unsignedBigInteger('status_setting_id')->nullable()->after('user_id');
            $table->foreign('status_setting_id')->references('id')->on('status_settings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks_users', function (Blueprint $table) {
            //
        });
    }
}
