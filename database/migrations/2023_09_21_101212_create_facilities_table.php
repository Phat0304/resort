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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon');
            $table->boolean('display')->default(true);
            $table->integer('priority');
            $table->timestamps();
        });

        DB::table('facilities')->insert([
            [
             'id' => 1,
             'name' => 'Wifi',
             'icon' => '/images/facilities/wifi.svg',
             'display' => true,
             'priority' => 1,
            ],
            [
             'id' => 2,
             'name' => 'โทรทัศน์',
             'icon' => '/images/facilities/television.svg',
             'display' => true,
             'priority' => 2,

            ],
            [
             'id' => 3,
             'name' => 'แอร์',
             'icon' => '/images/facilities/5.svg',
             'display' => true,
             'priority' => 3,

            ],
            [
             'id' => 4,
             'name' => 'พัดลม',
             'icon' => '/images/facilities/fan.svg',
             'display' => true,
             'priority' => 4,

            ],
            [
             'id' => 5,
             'name' => 'ตู้เย็น',
             'icon' => '/images/facilities/freezer.svg',
             'display' => true,
             'priority' => 5,

            ],
            [
             'id' => 6,
             'name' => 'อ่างอาบน้ำ',
             'icon' => '/images/facilities/bath-tub.svg',
             'display' => true,
             'priority' => 6,

            ],
            [
             'id' => 7,
             'name' => 'ตู้เสิ้อผ้า',
             'icon' => '/images/facilities/wardrobe.svg',
             'display' => true,
             'priority' => 7,

            ],
            [
             'id' => 8,
             'name' => 'โต๊ะเครื่องแป้ง',
             'icon' => '/images/facilities/dressing-table.svg',
             'display' => true,
             'priority' => 8,

            ],
            [
             'id' => 9,
             'name' => 'โต๊ะทำงาน',
             'icon' => '/images/facilities/desk-furniture.svg',
             'display' => true,
             'priority' => 9,

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
        Schema::dropIfExists('facilities');
    }
};
