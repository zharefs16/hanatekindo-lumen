<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStatusParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_status_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('par_id');
            $table->string('par_name');
            $table->string('par_status');
            $table->string('par_message');
            $table->string('par_attribute');
            $table->string('status');
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
        Schema::dropIfExists('user_status_parameters');
    }
}
