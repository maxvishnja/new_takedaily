<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTypePacker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
	        DB::statement("ALTER TABLE {$table->getTable()} CHANGE COLUMN type type ENUM('admin', 'user', 'packer')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
	        DB::statement("ALTER TABLE {$table->getTable()} CHANGE COLUMN type type ENUM('admin', 'user')");
        });
    }
}
