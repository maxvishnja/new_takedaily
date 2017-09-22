<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateGiftcardsAddCurrenct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('giftcards', function (Blueprint $table) {
	        $table->string('currency', 3)->default('DKK')->after('worth');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('giftcards', function (Blueprint $table) {
            $table->dropColumn('currency');
        });
    }
}
