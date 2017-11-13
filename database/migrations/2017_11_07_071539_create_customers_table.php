<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //咨询-患者
        Schema::create('zx_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('age')->nullable();
            $table->string('sex')->nullable();
            $table->string('tel')->nullable();
            $table->string('qq')->nullable();
            $table->string('wechat')->nullable();
            $table->unsignedInteger('idcard')->nullable()->comment('商务通身份id');
            $table->string('keywords')->nullable()->comment('搜索关键词');
            $table->string('city')->nullable()->comment('地区');
            $table->unsignedInteger('media_id')->nullable()->comment('媒体来源');
            $table->unsignedInteger('webtype_id')->nullable()->comment('网站类型');//
            $table->unsignedInteger('user_id')->nullable()->comment('咨询员');
            $table->unsignedInteger('trans_user_id')->nullable()->comment('商务通转电话人员');
            $table->unsignedInteger('customer_condition_id')->nullable()->comment('客户状态');//
            $table->text('description')->nullable()->comment('咨询内容');
            $table->timestamp('zixun_at')->nullable()->comment('咨询时间');
            $table->timestamp('yuyue_at')->nullable()->comment('预约时间');
            $table->timestamp('arrive_at')->nullable()->comment('到院时间');
            $table->unsignedInteger('office_id')->nullable()->comment('科室');
            $table->unsignedInteger('disease_id')->nullable()->comment('病种');
            $table->unsignedInteger('doctor_id')->nullable();
            $table->unsignedInteger('customer_type_id')->nullable()->comment('客户类型');//
            $table->text('addons')->nullable()->comment('备注');
            $table->timestamps();
        });
        //患者回访表
        Schema::create('huifangs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('zx_customer_id')->comment('患者id');
            $table->unsignedInteger('now_user_id')->nullable()->comment('本次回访人');
            $table->timestamp('now_at')->nullable()->comment('本次回访日期');
            $table->timestamp('next_at')->nullable()->comment('下次回访日期');
            $table->unsignedInteger('next_user_id')->nullable()->comment('下次回访人');
            $table->text('description')->nullable()->comment('本次回访记录');
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
        Schema::dropIfExists('zx_customers');
        Schema::dropIfExists('huifangs');
    }
}