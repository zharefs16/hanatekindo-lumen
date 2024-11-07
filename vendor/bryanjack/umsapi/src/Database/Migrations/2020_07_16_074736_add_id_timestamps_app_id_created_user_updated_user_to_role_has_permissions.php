<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdTimestampsAppIdCreatedUserUpdatedUserToRoleHasPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_has_permissions', function (Blueprint $table) {
            //
            $table->string('app_id');
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
        Schema::table('role_has_permissions', function (Blueprint $table) {
            //
            $table->dropColumn('app_id');
            $table->dropColumn('created_user');
            $table->dropColumn('updated_user');
        });
    }
}
