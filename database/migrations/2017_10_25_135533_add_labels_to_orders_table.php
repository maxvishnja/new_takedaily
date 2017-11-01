<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLabelsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('labellesskode', 100)->after('barcode');
            $table->string('labelTekst1', 100)->after('labellesskode');
            $table->string('labelTekst2', 100)->after('labelTekst1');
            $table->string('labelTekst3', 100)->after('labelTekst2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('labellesskode');
            $table->dropColumn('labelTekst1');
            $table->dropColumn('labelTekst2');
            $table->dropColumn('labelTekst3');
        });
    }
}
