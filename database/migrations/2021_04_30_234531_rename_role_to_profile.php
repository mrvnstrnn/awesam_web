<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRoleToProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('roles', 'profiles');
        Schema::rename('role_permissions', 'profile_permissions');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_role_id_foreign');

            $table->renameColumn('role_id', 'profile_id');

            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });

        Schema::table('profile_permissions', function (Blueprint $table) {
            $table->dropForeign('role_permissions_role_id_foreign');
            
            $table->renameColumn('role_id', 'profile_id');

            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');

        Schema::dropIfExists('roles');
    }
}
