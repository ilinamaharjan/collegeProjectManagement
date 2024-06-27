<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->unsignedBigInteger('from_status')->nullable();
            $table->unsignedBigInteger('to_status');
            $table->unsignedBigInteger('creator_user');

            $table->foreign('lead_id')->references('id')->on('leads');
            $table->foreign('from_status')->references('id')->on('lead_settings');
            $table->foreign('to_status')->references('id')->on('lead_settings');
            $table->foreign('creator_user')->references('id')->on('users');
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
        Schema::dropIfExists('status_histories');
    }
}
