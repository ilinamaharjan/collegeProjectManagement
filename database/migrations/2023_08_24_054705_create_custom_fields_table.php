<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_name');
            $table->unsignedBigInteger('field_type_id');
            $table->enum('status',['Show','Hide']);
            $table->string('html_element');
            $table->string('type');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('creator_user');
            $table->timestamps();

            
            $table->foreign('field_type_id')->references('id')->on('custom_field_types');
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('custom_fields');
    }
}
