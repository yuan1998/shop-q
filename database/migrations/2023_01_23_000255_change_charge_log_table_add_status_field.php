<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeChargeLogTableAddStatusField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charge_logs', function (Blueprint $table) {
            $table->unsignedInteger('status')->default(0);
            $table->dateTime('notify_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('charge_logs', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('notify_date');
            //
        });
    }
}
