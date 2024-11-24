<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('asset_code'); // Foreign key ke table assets
            $table->string('category_asset', 200)->nullable(); // Kolom category_asset
            $table->unsignedBigInteger('merk')->nullable(); // Foreign key ke table merk
            $table->string('spesification', 255)->nullable(); // Kolom spesification
            $table->string('serial_number', 255); // Kolom serial_number
            $table->unsignedBigInteger('name_holder')->nullable(); // Foreign key ke table customer
            $table->string('position', 255)->nullable(); // Kolom position
            $table->string('o365', 255)->nullable(); // Kolom o365
            $table->string('location', 255)->nullable(); // Kolom location
            $table->string('status', 50); // Kolom status
            $table->string('condition', 200)->nullable(); // Kolom condition
            $table->string('approval_status', 200)->nullable(); // Kolom approval_status
            $table->string('type_transactions', 50); // Kolom type_transactions
            $table->string('documentation', 255)->nullable(); // Kolom documentation
            $table->string('previous_customer_name', 200)->nullable(); // Kolom previous_customer_name
            $table->timestamps(); // Kolom created_at dan updated_at
            $table->decimal('latitude', 10, 7); // Kolom latitude
            $table->decimal('longitude', 10, 7); // Kolom longitude
            $table->string('reason', 255)->nullable(); // Kolom reason
            $table->string('note', 200)->nullable(); // Kolom note

            // Foreign key constraints
            $table->foreign('asset_code')->references('id')->on('assets')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('merk')->references('id')->on('merk')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('name_holder')->references('id')->on('customer')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
