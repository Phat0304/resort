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
        Schema::create('booking_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bg_color')->nullable()->default(null);

            $table->timestamps();
        });

        DB::table('booking_statuses')->insert([
            [
                'id' => 1,
                'name' => 'รอการตรวจสอบ',
                'bg_color' => 'warning',
            ],
            [
                'id' => 2,
                'name' => 'ตรวจสอบแล้ว',
                'bg_color' => 'primary',
            ],
            [
                'id' => 3,
                'name' => 'กำลังเข้าพัก',
                'bg_color' => 'info',
            ],
            [
                'id' => 4,
                'name' => 'เช็คเอาท์แล้ว',
                'bg_color' => 'success',
            ],
            [
                'id' => 5,
                'name' => 'ยกเลิก',
                'bg_color' => 'danger',
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
        Schema::dropIfExists('booking_statuses');
    }
};
