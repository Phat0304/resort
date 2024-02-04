<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('temp_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('temp_id');
            $table->integer('room_id');
            $table->string('ip_address')->nullable();
            $table->date('date_checkin');
            $table->date('date_checkout');
            $table->text('booking_date')->comment('วันที่เข้าพักทั้งหมด');
            $table->integer('days')->comment('จำนวนวัน');
            $table->string('booking_type')->nullable()->default(null)->comment('รูปแบบการจอง(online, walk-in)');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_bookings');
    }
};
