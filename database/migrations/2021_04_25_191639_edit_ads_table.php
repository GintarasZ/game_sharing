<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn("buyerId");
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn("buyerId2");
            $table->dropColumn('start_date2');
            $table->dropColumn('end_date2');
            $table->dropColumn("buyerId3");
            $table->dropColumn('start_date3');
            $table->dropColumn('end_date3');
            $table->integer('rent_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
