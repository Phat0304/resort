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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title');
            $table->text('site_about');
            $table->boolean('shutdown')->default(false);
            $table->timestamps();
        });

        DB::table('settings')->insert([
            [
             'id' => 1,
             'site_title' => 'สวนสบายปลายนารีสอร์ท',
             'site_about' => 'บริการห้องพักรายวัน 24 ชั่วโมง',
             'shutdown' => 0,
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
        Schema::dropIfExists('settings');
    }
};
