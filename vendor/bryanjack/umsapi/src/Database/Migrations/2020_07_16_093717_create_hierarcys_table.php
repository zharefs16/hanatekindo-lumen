<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHierarcysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hierarcys', function (Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->string('user_level');
            $table->string('name_level');
            $table->string('unit_id');
            $table->string('box_id');
            $table->string('created_date');
            $table->string('updated_date');
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
        Schema::dropIfExists('hierarcys');
    }
}
