<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_carts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id('cart_id');
            $table->foreignId('food_id')->constrained('foods', 'food_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->integer('qty');
            $table->boolean('is_deleted')->default(false);
            $table->string('created_by');
            $table->timestamp('created_time');
            $table->string('modified_by')->nullable();
            $table->timestamp('modified_time')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
