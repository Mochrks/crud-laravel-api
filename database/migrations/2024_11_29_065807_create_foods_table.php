<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_foods_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsTable extends Migration
{
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id('food_id');
            $table->foreignId('category_id')->constrained('categories', 'category_id');
            $table->string('food_name');
            $table->string('image_filename');
            $table->integer('price');
            $table->text('ingredient');
            $table->string('created_by');
            $table->timestamp('created_time');
            $table->string('modified_by')->nullable();
            $table->timestamp('modified_time')->nullable();
            $table->boolean('is_deleted')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('foods');
    }
}
