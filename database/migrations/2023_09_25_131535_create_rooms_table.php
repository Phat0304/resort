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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->text('description')->nullable()->default(null);
            $table->integer('adult');
            $table->integer('children');
            $table->string('area');
            $table->string('feature_ids');
            $table->string('fac_ids');
            $table->boolean('display')->default(true);
            $table->string('color_code')->nullable()->default(null);

            $table->timestamps();
        });

        DB::table('rooms')->insert([
            [
                'id' => 1,
                'name' => 'A1',
                'price' => 400,
                'description' => 'This is A1',
                'adult' => 2,
                'children' => 1,
                'area' => 22,
                'feature_ids' => '1, 3, 5, 7',
                'fac_ids' => '1, 3, 4, 5, 6, 7',
                'display' => true,
                'color_code' => '#4e73df',
            ],
            [
                'id' => 2,
                'name' => 'A2',
                'price' => 450,
                'description' => 'This is A2',
                'adult' => 2,
                'children' => 1,
                'area' => 23,
                'feature_ids' => '1, 3, 5, 7',
                'fac_ids' => '1, 3, 4, 5, 6, 7',
                'display' => true,
                'color_code' => '#1cc88a',
            ],
            [
                'id' => 3,
                'name' => 'A3',
                'price' => 500,
                'description' => 'This is A3',
                'adult' => 2,
                'children' => 2,
                'area' => 25,
                'feature_ids' => '1, 3, 5, 7',
                'fac_ids' => '1, 3, 4, 5, 6, 7, 8, 9',
                'display' => true,
                'color_code' => '#FF5733',
            ],
            [
                'id' => 4,
                'name' => 'A4',
                'price' => 400,
                'description' => 'This is A4',
                'adult' => 2,
                'children' => 1,
                'area' => 22,
                'feature_ids' => '1, 3, 5, 7',
                'fac_ids' => '1, 3, 4, 5, 6, 7',
                'display' => true,
                'color_code' => '#FFC300',
            ],
            [
                'id' => 5,
                'name' => 'A5',
                'price' => 450,
                'description' => 'This is A5',
                'adult' => 2,
                'children' => 1,
                'area' => 23,
                'feature_ids' => '1, 3, 5, 7',
                'fac_ids' => '1, 3, 4, 5, 6, 7',
                'display' => true,
                'color_code' => '#AF601A',
            ],
            [
                'id' => 6,
                'name' => 'A6',
                'price' => 550,
                'description' => 'This is 63',
                'adult' => 2,
                'children' => 2,
                'area' => 26,
                'feature_ids' => '1, 3, 5, 7',
                'fac_ids' => '1, 3, 4, 5, 6, 7, 8, 9',
                'display' => true,
                'color_code' => '#900C3F',
            ],
            [
                'id' => 7,
                'name' => 'A7',
                'price' => 400,
                'description' => 'This is A7',
                'adult' => 2,
                'children' => 1,
                'area' => 22,
                'feature_ids' => '1, 3, 5, 7',
                'fac_ids' => '1, 3, 4, 5, 6, 7',
                'display' => true,
                'color_code' => '#2E4053',
            ],
            [
                'id' => 8,
                'name' => 'A8',
                'price' => 450,
                'description' => 'This is A8',
                'adult' => 2,
                'children' => 1,
                'area' => 23,
                'feature_ids' => '1, 3, 5, 7',
                'fac_ids' => '1, 3, 4, 5, 6, 7',
                'display' => true,
                'color_code' => '#DAF7A6',
            ],
            [
                'id' => 9,
                'name' => 'A9',
                'price' => 600,
                'description' => 'This is A9',
                'adult' => 2,
                'children' => 2,
                'area' => 28,
                'feature_ids' => '1, 3, 5, 7',
                'fac_ids' => '1, 3, 4, 5, 6, 7, 8, 9',
                'display' => true,
                'color_code' => '#F08080',
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
        Schema::dropIfExists('rooms');
    }
};
