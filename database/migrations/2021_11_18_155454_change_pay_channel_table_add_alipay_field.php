<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePayChannelTableAddAlipayField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pay_channels', function (Blueprint $table) {
            $table->boolean('alipay_enable')->default(0);
            $table->string('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pay_channels', function (Blueprint $table) {
            $table->dropColumn('alipay_enable');
            $table->dropColumn('comment');
        });
    }
}
