<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name');
            $table->boolean('is_deleted')->default(false);
            $table->string('created_by');
            $table->timestamp('created_time');
            $table->string('modified_by')->nullable();
            $table->timestamp('modified_time')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
