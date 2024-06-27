<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('creator_user');
            $table->json('additional_fields')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('creator_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('organization_number',function(Blueprint $table){
            $table->unsignedBigInteger('organization_id');
            $table->string('contact_number');

            $table->foreign('organization_id')->references('id')->on('organizations');
        });

        Schema::create('organization_address',function(Blueprint $table){
            $table->unsignedBigInteger('organization_id');
            $table->string('address');

            $table->foreign('organization_id')->references('id')->on('organizations');
        });

        Schema::create('organization_email',function(Blueprint $table){
            $table->unsignedBigInteger('organization_id');
            $table->string('email');

            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
