<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username');
            $table->string('fullname');
            $table->string('password');
            $table->boolean('is_deleted')->default(false);
            $table->string('created_by');
            $table->timestamp('created_time');
            $table->string('modified_by')->nullable();
            $table->timestamp('modified_time')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
