<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationShips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function(Blueprint $table){
            $table->foreign('attendance_machine_id')->references('id')->on('attendance_machines');
        });

        Schema::table('role_user', function(Blueprint $table){
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('permission_role', function(Blueprint $table){
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('permission_id')->references('id')->on('permissions');
        });

        Schema::table('permission_user', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('permission_id')->references('id')->on('permissions');
        });

        Schema::table('timesheets', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('attendances', function(Blueprint $table){
            $table->foreign('timesheet_id')->references('id')->on('timesheets');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('attendance_machine_id')->references('id')->on('attendance_machines');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
