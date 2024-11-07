<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppIdCreatedUserUpdatedUserToRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
            $table->string('app_id')->nullable();
            $table->string('user_level')->nullable();
            $table->string('created_user')->nullable();
            $table->string('updated_user')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
            $table->dropColumn('app_id');
            $table->dropColumn('user_level');
            $table->dropColumn('created_user');
            $table->dropColumn('updated_user');
        });
    }
}
