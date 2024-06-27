<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('type');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->mediumText('title');
            $table->longText('additional_description')->nullable();
            $table->double('estimated_worth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            //
        });
    }
}
