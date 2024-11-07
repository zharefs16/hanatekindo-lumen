<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchsAdditionals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branchs_additionals', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('app_id');
            $table->string('branch_code');
            $table->string('created_user');
            $table->string('updated_user');
            $table->string('status');
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
        Schema::dropIfExists('branchs_additionals');
    }
}
