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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('profile_image');
            $table->string('password');
            $table->string('admin_role');
            $table->string('status');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        DB::table('admins')->insert([
            [
                'id' => 1,
                'username' => 'Phat03',
                'profile_image' => '/images/backoffice/superadmin.png',
                'password' => '$2y$10$NWqZXU3U7OgUO7XTl9UC0eqDeSRZMof2/xOQ2N.SUlIE6pD2uMd2y', /* ASDqwe123 */
                'admin_role' => 'แอดมินสูงสุด',
                'status' => 'เปิดใช้งาน',
                'email' => "phat030440@gmail.com",
            ],
            [
                'id' => 2,
                'username' => 'Admin1',
                'profile_image' => '/images/backoffice/admin.png',
                'email ' => "admin1@gmail.com",
                'password' => '$2y$10$xi9r9XV0lsLPQpFtYK5A7udQDxhumgZPhQihmsLqd/Ry0lj2tZOc.', /* asdqwe123 */
                'admin_role' => 'แอดมิน',
                'status' => 'เปิดใช้งาน',
            ],
            [
                'id' => 3,
                'username' => 'Admin2',
                'profile_image' => '/images/backoffice/admin.png',
                'email ' => "admin2@gmail.com",
                'password' => '$2y$10$xi9r9XV0lsLPQpFtYK5A7udQDxhumgZPhQihmsLqd/Ry0lj2tZOc.', /* asdqwe123 */
                'admin_role' => 'แอดมิน',
                'status' => 'ปิดใช้งาน',
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
        Schema::dropIfExists('admins');
    }
};
