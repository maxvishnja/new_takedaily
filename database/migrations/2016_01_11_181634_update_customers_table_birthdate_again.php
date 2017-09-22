<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomersTableBirthdateAgain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
			DB::statement("ALTER TABLE {$table->getTable()} MODIFY COLUMN birthday DATE");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
			DB::statement("ALTER TABLE {$table->getTable()} MODIFY COLUMN birthday DATETIME");
        });
    }
}
