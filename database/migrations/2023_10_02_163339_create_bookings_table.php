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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->integer('room_id');
            $table->integer('price_per_date')->nullable()->default(null);
            $table->integer('price');
            $table->date('date_checkin');
            $table->date('date_checkout');
            $table->text('booking_date')->comment('วันที่เข้าพักทั้งหมด');
            $table->integer('days')->comment('จำนวนวัน');
            $table->integer('status_id');
            $table->string('booking_type')->nullable()->default(null)->comment('รูปแบบการจอง(online, walk-in)');
            $table->string('cus_fname');
            $table->string('cus_lname');
            $table->string('cus_phone');
            $table->string('email');
            $table->string('note')->nullable()->default(null);
            $table->string('line_id')->nullable()->default(null);
            $table->string('card_id')->comment('เลขปปช');
            $table->string('four_id')->comment('เลขปปช.4ตัวท้าย');
            $table->string('payment_type');
            $table->string('slip')->nullable()->default(null);

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
        Schema::dropIfExists('bookings');
    }
};
