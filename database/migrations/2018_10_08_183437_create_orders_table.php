<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no')->unique();//下单流水号，唯一
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('address');
            $table->decimal('total_amount');
            $table->text('remark')->nullable();//订单备注
            $table->dateTime('paid_at')->nullable();//支付时间
            $table->string('payment_method')->nullable();
            $table->string('payment_no')->nullable();//支付平台订单号
            $table->string('refund_status')->default(App\Models\Order::REFUND_STATUS_PENDING);
            $table->string('refund_no')->nullable();
            $table->boolean('closed')->default(false);
            $table->boolean('reviewed')->default(false);
            $table->string('ship_status')->default(App\Models\Order::SHIP_STATUS_PENDING);//物流状态
            $table->string('ship_data')->nullable();//物流数据
            $table->text('extra')->nullable();//额外的数据
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
        Schema::dropIfExists('orders');
    }
}
