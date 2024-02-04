<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_number');
            $table->boolean('display');
            $table->integer('priority');
            $table->string('bank_image');

            $table->timestamps();
        });

        DB::table('banks')->insert([
            [
                'id' => 1,
                'bank_name' => 'ธนาคารกสิกรไทย',
                'account_name' => 'นาย สายเปย์ โอนไว',
                'account_number' => '123-4-56789-0',
                'priority' => 1,
                'display' => 1,
                'bank_image' => "/images/bank/k-bankqr.png",
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
    }
};
