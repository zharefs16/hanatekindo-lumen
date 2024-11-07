<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppIdCreatedUserUpdatedUserToPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
            $table->string('app_id');
            $table->string('created_user');
            $table->string('updated_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
            $table->dropColumn('app_id');
            $table->dropColumn('created_user');
            $table->dropColumn('updated_user');
        });
    }
}
