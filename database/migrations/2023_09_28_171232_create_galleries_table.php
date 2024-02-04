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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->string('image');
            $table->boolean('default')->default(0);
            $table->foreign('room_id')
                    ->references('id')
                    ->on('rooms')
                    ->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('galleries')->insert([
            [
                'room_id' => 1,
                'image' => '/images/rooms/1.png',
                'default' => 1,
            ],
            [
                'room_id' => 1,
                'image' => '/images/rooms/2.png',
                'default' => 0,

            ],
            [
                'room_id' => 2,
                'image' => '/images/rooms/2.png',
                'default' => 1,

            ],
            [
                'room_id' => 2,
                'image' => '/images/rooms/3.png',
                'default' => 0,

            ],
            [
                'room_id' => 3,
                'image' => '/images/rooms/5.png',
                'default' => 1,

            ],
            [
                'room_id' => 3,
                'image' => '/images/rooms/6.png',
                'default' => 0,

            ],
            [
                'room_id' => 3,
                'image' => '/images/rooms/7.png',
                'default' => 0,

            ],
            [
                'room_id' => 3,
                'image' => '/images/rooms/4.png',
                'default' => 0,

            ],
            [
                'room_id' => 4,
                'image' => '/images/rooms/2.png',
                'default' => 1,
            ],
            [
                'room_id' => 4,
                'image' => '/images/rooms/3.png',
                'default' => 0,

            ],
            [
                'room_id' => 4,
                'image' => '/images/rooms/5.png',
                'default' => 0,

            ],
            [
                'room_id' => 5,
                'image' => '/images/rooms/3.png',
                'default' => 1,

            ],
            [
                'room_id' => 5,
                'image' => '/images/rooms/5.png',
                'default' => 0,

            ],
            [
                'room_id' => 6,
                'image' => '/images/rooms/6.png',
                'default' => 1,

            ],
            [
                'room_id' => 7,
                'image' => '/images/rooms/7.png',
                'default' => 1,

            ],
            [
                'room_id' => 8,
                'image' => '/images/rooms/4.png',
                'default' => 1,

            ],
            [
                'room_id' => 8,
                'image' => '/images/rooms/1.png',
                'default' => 0,

            ],
            [
                'room_id' => 9,
                'image' => '/images/rooms/2.png',
                'default' => 1,

            ],
            [
                'room_id' => 9,
                'image' => '/images/rooms/4.png',
                'default' => 0,

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
        Schema::dropIfExists('galleries');
    }
};
