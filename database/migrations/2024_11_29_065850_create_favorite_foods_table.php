<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_favorite_foods_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoriteFoodsTable extends Migration
{
    public function up()
    {
        Schema::create('favorite_foods', function (Blueprint $table) {
            $table->foreignId('food_id')->constrained('foods', 'food_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->boolean('is_favorite')->default(false);
            $table->string('created_by');
            $table->timestamp('created_time');
            $table->string('modified_by')->nullable();
            $table->timestamp('modified_time')->nullable();
            $table->primary(['food_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorite_foods');
    }
}
