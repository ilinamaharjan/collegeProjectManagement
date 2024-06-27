<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_settings', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->json('html_value')->nullable();
            $table->unsignedBigInteger('creator_user');
            $table->timestamps();

            $table->foreign('creator_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_settings');
    }
}
