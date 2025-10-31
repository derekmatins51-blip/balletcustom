<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalletCardDetailsToBalletCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ballet_cards', function (Blueprint $table) {
            $table->string('primary_account_deposit_address')->nullable();
            $table->string('primary_account_type')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('pass_phrase')->nullable();
            $table->decimal('balance', 13, 2)->default(0.00);
            $table->string('currency')->default('USD');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ballet_cards', function (Blueprint $table) {
            $table->dropColumn([
                'primary_account_deposit_address',
                'primary_account_type',
                'serial_number',
                'pass_phrase',
                'balance',
                'currency',
            ]);
        });
    }
}
