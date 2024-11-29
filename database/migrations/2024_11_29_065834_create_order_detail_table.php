<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_order_detail_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailTable extends Migration
{
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id('order_detail_id');
            $table->foreignId('food_id')->constrained('foods', 'food_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id');
            $table->integer('qty');
            $table->integer('total_price');
            $table->string('created_by');
            $table->timestamp('created_time');
            $table->string('modified_by')->nullable();
            $table->timestamp('modified_time')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_detail');
    }
}
