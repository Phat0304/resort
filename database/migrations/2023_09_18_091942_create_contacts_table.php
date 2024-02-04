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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('gmap');
            $table->string('phone1');
            $table->string('phone2')->nullable()->default(null);
            $table->string('email');
            $table->string('fb')->nullable()->default(null);
            $table->string('line')->nullable()->default(null);
            $table->string('ig')->nullable()->default(null);
            $table->text('iframe')->nullable()->default(null);

            $table->timestamps();
        });

        DB::table('contacts')->insert([
            [
             'id' => 1,
             'address' => '123/3 Sila Khonkaen 40000',
             'gmap' => 'https://maps.app.goo.gl/WvEWra4Ks47Wv2bu9',
             'phone1' => '0999999999',
             'phone2' => '0923333333',
             'email' => 'hotel@gmail.com',
             'fb' => 'facebook.com/hotelbooking',
             'line' => 'line.me',
             'iframe' => 'https://www.google.com/maps/embed?pb=!1m17!1m11!1m3!1d411771.6170829172!2d102.22084010865298!3d16.49382902120054!2m2!1f0!2f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31221164d20c42d9%3A0x828ce61718feeae6!2z4Liq4Lin4LiZ4Liq4Lia4Liy4Lii4Lib4Lil4Liy4Lii4LiZ4Liy4Lij4Li14Liq4Lit4Lij4LmM4LiXIChTdWFuIFNhYmFpIFBsYWkgTmEgUmVzb3J0KQ!5e0!3m2!1sth!2sth!4v1697286176328!5m2!1sth!2sth',
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
        Schema::dropIfExists('contacts');
    }
};
