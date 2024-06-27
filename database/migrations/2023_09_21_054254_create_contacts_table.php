<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->json('additional_fields')->nullable();
            $table->unsignedBigInteger('creator_user');
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->foreign('creator_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });

        Schema::create('contact_email', function (Blueprint $table){
            $table->unsignedBigInteger('contact_id');
            $table->string('email');
            $table->foreign('contact_id')->references('id')->on('contacts');
        });

        Schema::create('contact_phone',function (Blueprint $table){
            $table->unsignedBigInteger('contact_id');
            $table->string('phone_number');
            $table->foreign('contact_id')->references('id')->on('contacts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
