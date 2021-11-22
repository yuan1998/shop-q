<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOrderTableAddPayChannelField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('pay_channel_id')->nullable();
            $table->dateTime('send_at')->nullable();
            $table->integer('return_status')->default(0);
            $table->dateTime('return_at')->nullable();
            $table->string('return_reason')->nullable();
            $table->text('return_location')->nullable();
            $table->string('return_logistics_number')->nullable();
            $table->text('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('pay_channel_id');
            $table->dropColumn('send_at');
            $table->dropColumn('return_status');
            $table->dropColumn('return_at');
            $table->dropColumn('return_reason');
            $table->dropColumn('return_location');
            $table->dropColumn('return_logistics_number');
            $table->dropColumn('comment');
        });
    }
}
