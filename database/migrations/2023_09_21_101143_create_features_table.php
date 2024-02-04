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
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('display')->default(true);
            $table->integer('priority');
            $table->timestamps();
        });

        DB::table('features')->insert([
            [
             'id' => 1,
             'name' => 'เตียงเดี่ยว',
             'display' => true,
             'priority' => 1,
            ],
            [
             'id' => 2,
             'name' => 'เตียงคู่',
             'display' => true,
             'priority' => 2,
            ],
            [
             'id' => 3,
             'name' => 'ห้องน้ำในตัวห้อง',
             'display' => true,
             'priority' => 3,
            ],
            [
             'id' => 4,
             'name' => 'ห้องน้ำนอกตัวห้อง',
             'display' => true,
             'priority' => 4,
            ],
            [
             'id' => 5,
             'name' => 'มีระเบียง',
             'display' => true,
             'priority' => 5,
            ],
            [
             'id' => 6,
             'name' => 'มีที่เขี่ยบุหรี่',
             'display' => true,
             'priority' => 6,
            ],
            [
             'id' => 7,
             'name' => 'ห้องปลอดบุหรี่',
             'display' => true,
             'priority' => 7,
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
        Schema::dropIfExists('features');
    }
};
