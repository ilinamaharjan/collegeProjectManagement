<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdToLeadFileTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_file_types', function (Blueprint $table) {
            $table->unsignedBigInteger('creator_user')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();

            $table->foreign('creator_user')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_file_types', function (Blueprint $table) {
            //
        });
    }
}
