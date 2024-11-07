<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAdditionalsSchemaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_additionals_schema', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->string('field_name');
            $table->string('label_name');
            $table->string('mandatory');
            $table->string('data_type');
            $table->string('length');
            $table->string('input_type');
            $table->string('default_value');
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
        Schema::dropIfExists('users_additionals_schema');
    }
}
