<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB; // Tambahkan untuk menggunakan DB facade
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->id(); // id sebagai primary key
            $table->string('username', 255);
            $table->string('password', 255);
            $table->string('role', 50);
            $table->string('nrp', 50);
            $table->string('name', 50);
            $table->string('mapping', 50)->nullable(); // Boleh NULL
            $table->string('login_method', 200)->nullable(); // Boleh NULL
            $table->timestamps(); // Untuk created_at dan updated_at
        });

        // Insert default admin user
        DB::table('customer')->insert([
            'username' => 'admin@gmail.com',
            'password' => bcrypt('admin'), // Mengenkripsi password
            'role' => 'admin',
            'nrp' => '00001',
            'name' => 'Administrator',
            'mapping' => null,
            'login_method' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
