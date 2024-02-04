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
        Schema::create('carousels', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->integer('page_id')->default(0);
            $table->boolean('display')->default(true);
            $table->integer('priority')->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        DB::table('carousels')->insert([
            [
             'id' => 1,
             'image' => '/images/carousel/1.png',
             'display' => true,
             'priority' => 1,
            ],
            [
             'id' => 2,
             'image' => '/images/carousel/2.png',
             'display' => true,
             'priority' => 2,
            ],
            [
             'id' => 3,
             'image' => '/images/carousel/3.png',
             'display' => true,
             'priority' => 3,
            ],
            [
             'id' => 4,
             'image' => '/images/carousel/4.png',
             'display' => true,
             'priority' => 4,
            ],
            [
             'id' => 5,
             'image' => '/images/carousel/5.png',
             'display' => true,
             'priority' => 5,
            ],
            [
             'id' => 6,
             'image' => '/images/carousel/6.png',
             'display' => true,
             'priority' => 6,
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
        Schema::dropIfExists('carousels');
    }
};
