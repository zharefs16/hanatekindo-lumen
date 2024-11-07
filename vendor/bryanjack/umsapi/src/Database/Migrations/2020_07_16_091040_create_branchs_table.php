<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('unit_code');
            $table->string('unit_name');
            $table->string('sub_parent_code');
            $table->string('sub_parent_Name');
            $table->string('parent_code');
            $table->string('parent_Name');
            $table->string('channel_code');
            $table->string('channel_Name'); 
            $table->string('unit_type'); 
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
        Schema::dropIfExists('branchs');
    }
}
