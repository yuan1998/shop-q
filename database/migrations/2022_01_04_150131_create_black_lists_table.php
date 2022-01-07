<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlackListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 添加类型  :  手动添加、自动添加
        // 类型     :  ip 、 电话
        // 值       :  被禁止的值
        // 备注
        // 例：
        /**
         * {
         添加类型 : '手动添加'，
         类型 ： ’ip‘
         值 ： ’1.1.1.1‘，
         备注： ’‘
         * }
         */
        Schema::create('black_lists', function (Blueprint $table) {
            $table->id();
            $table->string('add_type')->nullable();
            $table->string('type')->nullable();
            $table->string('value')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('black_lists');
    }
}
