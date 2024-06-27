<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name');
            $table->unsignedBigInteger('creator_user_id')->nullable();
            $table->unsignedBigInteger('parent_module_id')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->foreign('creator_user_id')->references('id')->on('users')->onDelete('Restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
