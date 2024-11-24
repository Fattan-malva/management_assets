<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id(); // Kolom id sebagai primary key
            $table->string('code', 50); // Kolom code
            $table->string('category', 200); // Kolom category
            $table->unsignedBigInteger('merk'); // Kolom merk (foreign key)
            $table->string('serial_number', 50); // Kolom serial_number
            $table->string('entry_date', 200); // Kolom entry_date
            $table->string('spesification', 50); // Kolom spesification
            $table->string('condition', 200); // Kolom condition
            $table->enum('status', ['Operation', 'Inventory'])->default('Inventory'); // Kolom status
            $table->string('location', 255)->nullable(); // Kolom location
            $table->datetime('handover_date')->nullable(); // Kolom handover_date
            $table->string('last_maintenance', 200)->nullable(); // Kolom last_maintenance
            $table->string('scheduling_maintenance', 200); // Kolom scheduling_maintenance
            $table->string('note_maintenance', 200); // Kolom note_maintenance
            $table->string('name_holder', 200)->nullable(); // Kolom name_holder
            $table->date('next_maintenance')->nullable(); // Kolom next_maintenance
            $table->decimal('starting_price', 10, 0); // Kolom starting_price
            $table->string('asset_age', 200); // Kolom asset_age

            // Definisi foreign key untuk merk
            $table->foreign('merk')
                ->references('id')
                ->on('merk')
                ->onDelete('restrict') 
                ->onUpdate('restrict'); // Membatasi pembaruan pada merk
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
