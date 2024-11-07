<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAdditionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_additionals', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->string('user_id');
            $table->string('field_name');
            $table->string('value')->nullable();
            $table->string('created_user');
            $table->string('updated_user');
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
        Schema::dropIfExists('users_additionals');
    }
}
