<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVitaminsTableType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vitamins', function (Blueprint $table) {
            $table->string('type', 16)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vitamins', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
